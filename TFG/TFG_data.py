import pandas as pd

file_x='ac_feedback.xlsx'
df = pd.read_excel(file_x, sheetname='ac_feedback')
dict_list=[]
i=-1
for categori in df.columns:
    i+=1
    dict_list.append(categori)
    i=i+1
    dict_list.append({})
    for row_dt in df[categori]:
        if row_dt not in dict_list[i]:
            dict_list[i][row_dt]=1
        elif row_dt in dict_list[i]:
            dict_list[i][row_dt] += 1
#print(dict_list)

final_dict={}
num_items = len(dict_list)
even_list=[dict_list[0]]
odd_list=[dict_list[1]]
for item in range(2, num_items):
    if item%2==0:
        even_list.append(dict_list[item])
    else:
        odd_list.append(dict_list[item])
print(even_list)
print(odd_list)

j=-1
int_list=[5,4,3,2,1]  
#print(pd.DataFrame({1:[51,41,31]}, index=[5,4,3]))
finallist=[]
for value in odd_list:
    finallist.append([])
    j=j+1
    for inteja in int_list:
        if inteja not in value:
            finallist[j].append(0)
        else:
            finallist[j].append(value[inteja])
            
print(finallist)

for label in range(len(even_list)):
    final_dict[even_list[label]]=finallist[label]
    
print(final_dict)
df=pd.DataFrame(final_dict, index=int_list)
df.to_excel('final_ac_feedback.xlsx', sheet_name='sheet1', index=False)