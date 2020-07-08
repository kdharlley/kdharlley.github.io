import sys, socket, selectors, types, json,time, errno, os

sel = selectors.DefaultSelector()

HOST ='localhost'
BASE_PORT = 20410
EVENTS = selectors.EVENT_READ | selectors.EVENT_WRITE
EVENTS_READ = selectors.EVENT_READ


class Server():
    def __init__(self, masterport, pid, max_process):
        self.server_socket = self.make_socket(socket.socket(socket.AF_INET, socket.SOCK_STREAM), int(masterport))
        self.master_socket = None
        self.client_socket = None
        self.pid = int(pid)
        self.max_process = int(max_process)
        self.message_list = []
        self.count= 0
        self.alive_list = {}
        sel.register(self.server_socket, EVENTS_READ, data=None)
        self.client2client()
        self.initiate_servers(HOST, int(max_process), self.pid)

    def make_socket(self, socket_obj, port_number):
        socket_obj.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
        socket_obj.bind((HOST, port_number))
        socket_obj.listen()
        socket_obj.setblocking(False)
        return socket_obj

    def master_accept(self, client_socket):
        cl_conn, cl_address = client_socket.accept()
        self.master_socket= cl_conn
        data = types.SimpleNamespace(address=cl_address, message_list=[], alive_servers=[],  )
        sel.register(cl_conn, EVENTS_READ, data=data)    
        

    def client2client(self):
        self.client_socket = self.make_socket(socket.socket(socket.AF_INET, socket.SOCK_STREAM), self.pid+BASE_PORT)
        sel.register(self.client_socket, EVENTS_READ, data=None)

    def client_accept(self, client_socket):
        try:
            cl_conn, cl_address = client_socket.accept()
        except Exception as e:
            pass
        else:
            self.count += 1
            cl_conn.setblocking(False)
            data = types.SimpleNamespace(address=cl_address, message_list=[], alive_servers=[],  )
            sel.register(cl_conn, EVENTS, data=data)
            message = {"header":"alive_list", "pid": str(self.pid), "first":True}
            json_message = self.process_json(message)
            self.client_socket = cl_conn
            try:
                sent = cl_conn.sendall(json_message)
            except Exception as e:
                pass

    def start(self):      
        while True:
            events = sel.select(timeout=None)
            for socket_object, event_mask in events:
                if socket_object.data is None and self.master_socket is None:
                    self.master_accept(socket_object.fileobj)
                elif socket_object.data is None:
                    self.client_accept(socket_object.fileobj)
                else:
                    self.process_event(socket_object, event_mask) 

    def process_json(self, message):
        json_string = json.dumps(message) + "\n"
        json_message = json_string.encode('utf-8')
        return json_message

    # have case where send more data than you can accept
    def process_event(self, socket_object, event_mask):
        socket_obj = socket_object.fileobj
        if event_mask & selectors.EVENT_READ:
            try:
                temp = b''
                while True:
                    inbound_data = socket_obj.recv(4096)
                    temp = temp + inbound_data
                    if (temp[-1:]==b'\n'):
                        inbound_data = temp
                        break
                    if (not inbound_data):
                        break
            except BlockingIOError as e:
                pass
            else:
                if inbound_data:
                    instructions = inbound_data.decode("utf-8").split('\n')
                    instructions = instructions[:-1]
                if socket_obj == self.master_socket:
                    for instruction in instructions:
                        inbound_data = instruction
                        received = inbound_data.split()
                        if received[0]== 'get':
                            joint_messages = "messages "+",".join(self.message_list)
                            get_reply = (str(len(joint_messages))+"-"+joint_messages).encode('utf-8')
                            socket_obj.sendall(get_reply)
                        if received[0]=='alive':
                            alive_pids = list(self.alive_list.keys())
                            alive_pids.append(str(self.pid))
                            alive_pids.sort()
                            joint_messages = "alive "+",".join(alive_pids)
                            alive_reply = (str(len(joint_messages))+"-"+joint_messages).encode('utf-8')
                            socket_obj.sendall(alive_reply)
                        if received[0]=='broadcast':
                            broadcast_message = " ".join(received[1:])
                            self.message_list.append(broadcast_message)
                            for pid in self.alive_list:
                                sock_connect = self.alive_list[pid]
                                message = {"header":"broadcast", "message": broadcast_message}
                                json_message = self.process_json(message)
                                byte_length = sock_connect.sendall(json_message)
                elif inbound_data:
                    for string_inbound in instructions:
                        inbound_dict = json.loads(string_inbound)
                        if inbound_dict["header"]=="alive_list":
                            self.alive_list.update({str(inbound_dict["pid"]): socket_obj})
                            if inbound_dict["first"]:
                                message = {"header":"alive_list", "pid": str(self.pid), "first":False}
                                json_message = json_message = self.process_json(message)
                                try:
                                    sent = socket_obj.sendall(json_message)
                                except Exception as e:
                                    pass
                        if inbound_dict["header"]=="broadcast":
                            self.message_list.append(inbound_dict["message"])
                else:
                    for key in self.alive_list:
                        if self.alive_list[key]==socket_obj:
                            pid_to_close = key
                            break
                    # declared pid to close somewhere
                    closed_sock = self.alive_list.pop(pid_to_close)
                    # CLOSING ADDITIONAL SOCKET?
                    sel.unregister(closed_sock)
                    closed_sock.close()
        if event_mask & selectors.EVENT_WRITE:
            pass


    def initiate_servers(self, HOST, max_process, pid):
        for other_pid in range(max_process):
            if other_pid == pid:
                continue
            try:
                socket_obj = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
                socket_obj.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 5)
                socket_obj.bind((HOST, BASE_PORT+other_pid)) 
            except:                  
                server_addr = (HOST, BASE_PORT+other_pid)
                sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
                sock.setblocking(False)
                sock.connect_ex(server_addr)
                data = types.SimpleNamespace(address=sock, message_list=[], alive_servers=[],  )
                sel.register(sock, EVENTS, data=data)
                self.alive_list.update({str(other_pid): sock})
            else:
                socket_obj.close()
                socket_obj = None

pid, max_process, masterport = sys.argv[1:4]
def main():
    server = Server(masterport, pid, max_process)
    server.start()

if __name__ == '__main__':
    main()




