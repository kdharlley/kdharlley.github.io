-- TODO: Put ALL SQL in between `BEGIN TRANSACTION` and `COMMIT`
BEGIN TRANSACTION;

CREATE TABLE `users` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`first_name` TEXT NOT NULL,
    'username' TEXT NOT NULL UNIQUE,
    'password' TEXT NOT NULL
);

CREATE TABLE `images` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`user_id` INTEGER NOT NULL,
	'extension' TEXT NOT NULL,
    'bio' TEXT
);


CREATE TABLE `tags` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    'tag_name' TEXT NOT NULL UNIQUE
);

CREATE TABLE `image_tags` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    'tag_id' INTEGER NOT NULL,
    'image_id' INTEGER NOT NULL
);

CREATE TABLE 'sessions'(
  	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    `user_id` INTEGER NOT NULL,
    'session' TEXT NOT NULL UNIQUE
);

INSERT INTO `users` (first_name, username, password) VALUES ('Ken', 'pdk33', '$2y$10$IC.B925TeEUoGiHLAhke0OMn6QT5mNRNOyGqAeq6Z/ZE9exSueVuS');
/* password: donkey*/
INSERT INTO `users` (first_name, username, password) VALUES ('Ben', 'bbk33', '$2y$10$1/Dt0E6.bpygkyBRONoM.e97HjbFRd6bnDH4y/JxsRRSY2ldDeDx6');
/* password: lion*/

INSERT INTO 'images' (user_id, extension, bio) VALUES (1, 'png', 'Fierce and Majestic');
INSERT INTO 'images' (user_id, extension, bio) VALUES (2, 'jpg', 'Fierce');
INSERT INTO 'images' (user_id, extension, bio) VALUES (1, 'jpeg', ' Majestic');
INSERT INTO 'images' (user_id, extension, bio) VALUES (2, 'png', 'Fierce and Majestic');
INSERT INTO 'images' (user_id, extension, bio) VALUES (2, 'jpg', 'Fierce and Majestic');
INSERT INTO 'images' (user_id, extension, bio) VALUES (1, 'jpeg', 'Lonely Creature');
INSERT INTO 'images' (user_id, extension, bio) VALUES (2, 'png', 'Fierce and Majestic');
INSERT INTO 'images' (user_id, extension, bio) VALUES (1, 'jpeg', 'Tall and vicious');
INSERT INTO 'images' (user_id, extension, bio) VALUES (1, 'jpg', 'Venomous');
INSERT INTO 'images' (user_id, extension, bio) VALUES (1, 'png', 'Fierce and Majestic');

INSERT INTO 'tags'(tag_name) VALUES ('lonely');
INSERT INTO 'tags'(tag_name) VALUES ('venom');
INSERT INTO 'tags'(tag_name) VALUES ('courageous');
INSERT INTO 'tags'(tag_name) VALUES ('smiles');
INSERT INTO 'tags'(tag_name) VALUES ('fights');

INSERT INTO 'image_tags'(tag_id, image_id) VALUES (1, 1);
INSERT INTO 'image_tags'(tag_id, image_id) VALUES (2, 1);
INSERT INTO 'image_tags'(tag_id, image_id) VALUES (3, 1);
INSERT INTO 'image_tags'(tag_id, image_id) VALUES (1, 2);
INSERT INTO 'image_tags'(tag_id, image_id) VALUES (2, 3);
INSERT INTO 'image_tags'(tag_id, image_id) VALUES (3, 4);
INSERT INTO 'image_tags'(tag_id, image_id) VALUES (1, 5);
INSERT INTO 'image_tags'(tag_id, image_id) VALUES (2, 6);
INSERT INTO 'image_tags'(tag_id, image_id) VALUES (3, 7);
INSERT INTO 'image_tags'(tag_id, image_id) VALUES (1, 8);
INSERT INTO 'image_tags'(tag_id, image_id) VALUES (2, 8);
INSERT INTO 'image_tags'(tag_id, image_id) VALUES (3, 7);
-- TODO: create tables

-- CREATE TABLE `examples` (
-- 	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
-- 	`name`	TEXT NOT NULL
-- );


-- TODO: initial seed data

-- TODO: FOR HASHED PASSWORDS, LEAVE A COMMENT WITH THE PLAIN TEXT PASSWORD!

-- INSERT INTO `examples` (id,name) VALUES (1, 'example-1');
-- INSERT INTO `examples` (id,name) VALUES (2, 'example-2');

COMMIT;
