# Project 3: Design Journey

Your Name: Kenneth D. Harlley[insert your name here]

**All images must be visible in Markdown Preview. No credit will be provided for images in your repository that are not properly linked in Markdown. Assume all file paths are case sensitive!**


# Project 3, Milestone 1 - Design, Plan, & Draft Website

## Describe your Gallery

[What will your gallery be about? 1 sentence.]
My gallery will be a collection of animals photographed by a student group in Cornell

## Target Audiences

[Tell us about your target two audiences. ~1-3 sentences per audience]
Cornell Student Animal Photographers: These are students who are just being introduced into taking pictures but know a ton about animals. They are learning how to tag pictures as well as how to properly take them

Cornell Prospective Animal Photographers: These are students who are thinking of getting into taking picture of animals and the such, however, they have very little knowledge of animals and the such.




## Design Process

[Document your design process. Show us the evolution of your design from your first idea (sketch) to design you wish to implement (sketch). Show us the process you used to organize content and plan the navigation (e.g. card sorting).]

[Label all images. All labels must be visible in Markdown Preview.]

Home Cardsorting:
![Homepage Cardsorting](home_cs.jpg)

Images Cardsorting:
![Images PageCardsorting](images_cs.jpg)

Uploads Cardsorting:
![Uploads Page  Cardsorting](uploads_cs.jpg)

First Home Page Design:
![Homepage sketch](home0.jpg)

Final Home Page Design:
![Homepage sketch](home1.jpg)

First Images Page Design:
![Images Page sketch](images0.jpg)

Final Images Page Design:
![Images Page sketch](images1.jpg)

First Animals Page Desgn:
![Animals Page sketch](animal0.jpg)

Final Animals Page Desgn:
![Animals Page sketch](animals1.jpg)

First Uploads Page Design:
![Uploads Page sketch](uploads0.jpg)

Final Uploads Page Design:
![Uploads Page sketch](uploads1.jpg)


## Final Design Plan

[Include sketches of your final design here.]


Final Home Page Design:
![Homepage sketch](home2.jpg)

Final Images Page Design:
![Images Page sketch](images2.jpg)

Final Uploads Page Design:
![Uploads Page sketch](uploads2.jpg)

Final Animals Page Desgn:
![Animals Page sketch](animals2.jpg)

## Templates

[Identify the templates you will use on your site.]
head: This will contain all my html meta tags
header: this will contain my landing image as well as my navbar
init: Will also contain my functions, as well as any global variable declararions
finalref: will contain the reference to my landing image

## Database Schema Design

[Describe the structure of your database. You may use words or a picture. A bulleted list is probably the simplest way to do this. Make sure you include constraints for each field.]

[Hint: You probably need `users`, `images`, `tags`, and `image_tags` tables.]

[Hint: For foreign keys, use the singular name of the table + _id. For example: 1) `user_id` in the `images` table or 2) `image_id` and `tag_id` for the `image_tags` table.]

```
'sessions'{
  	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
    `user_id` INTEGER NOT NULL,
    'session' TEXT NOT NULL UNIQUE
}

`users` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`first_name` TEXT NOT NULL,
  'username' TEXT NOT NULL UNIQUE,
  'password' TEXT NOT NULL
);

`images` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`user_id` INTEGER NOT NULL,
	'extension' TEXT NOT NULL,
  'bio' TEXT
);


`tags` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  'tag_name' TEXT NOT NULL UNIQUE
);

`image_tags` (
	`id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  'tag_id' INTEGER NOT NULL,
  'image_id' INTEGER NOT NULL
);

```


## Code Planning

[Plan what top level PHP pages you'll need.]
images.php
index.php
animal.php
uploads.php

[Plan what templates you'll need.]


```
"For outputting Image Records on Image Page
for every posts{(sql query below)
  for every tag on image(sql query below){
    output tag button
  }
  Escape all output
  Output insert new tag input
  Output add existing tag input and bio
  Output Delete button and confirm changes button
}


"Code For deleting a tag
if tag button clicked and user created image and user logged on{
  delete tag(sql query below)
}

"Confirming changes for a tag
if confirm changes button clicked {
  filter input
  if new tag field filled insert new tag turned to lowercase(sql query below)
  if insert tag field filled insert tag(sql query below)
  confirm changes with regards to tags
}

"Code for deleting image
if delete button clicked and user created image and user logged on{
  delete image(sql query below)
}

"Code for viewing image
if view button clicked{
  show only image by selecting image with id (sql query below)
}

"Searching for images with specific tag
if search button hit{
  filter and sanitize input
  escape SQL characters
  check if any matches with tag
}

"Code for shwowing all images
if all images button clicked{
  execute SQL query to get all images
  output all image
}

"Code for login button in navbar
If login navbar button clicked{
  Go to index.php where login button located
}

"Code for logging a user in
If login form submit button clicked and credentials right{
  Go to index.php and log user in
}
else{
  refresh page
}

"Code for logging out
If logout navbar button clicked{
  Go to index.php and destroy session
}

"Code for what to display on navbar
If user logged in{
  Display logout button with escaped user's name on navbar
}
else{
  Display login button on navbar
}

"Code for uploading data
if submit button clicked and user logged in{
  Sanitize input
  Insert Data in database with query(sql query below)
}

"Code for checking if tag already in database when making new tag
If tag already in database{
  do nothing
} else{
  filter input
  create new tag and insert it into database(sql query below)
}

"Code for checking if tag already attached to image
If tag already attached to image{
  do nothing
} else {
  filter input
  add tag to image(sql query below)
}

[Plan any PHP code you'll need.]
function log_out()
  This function logs a user out, by setting a cookie's expiry time into the past by about 10,000 second, causing the cookie to be destroyed, after which the current user variable is set to null to show no user is logged in

function session_login()
If a cookie has been set, the previous function using the cookie finds the user which matches the session id in the cookie and returns this users record. This function then amends the cookie's expiry time to thirty minutes into the future and then returns the user. If theres no user matching the session id both functions return null also if no cookie has been set, this function returns null

function find_session($session_id)
We initially check if a session id has been set. If it has, we match this session id to the corresponding session record and then finally return the session record which should be unique. However, if there is no corresponding session, null is returned

function log_in($username, $password)
  Returns any record with a matching username. if there is a matching record, the password of the record is checked against the inputted password, since the password is hashed we use a function to accomplish this. if the passwords match, a session id is generated and stored in the database in a record which corresponds to the user so the server knows who is logged on at a particular time. This session is also given an expiry date which refreshes every 30 minutes depending on activity

function find_user()
Using the unique user id, this function finds the users record and returns it, if no user is found NULL is returned

function is_user_logged_in()
  If user is logged in{
    return true
  } else {
    return false
  }

function tags_output(current_image_id){
  execute SQL query to obtain all tags for a particular image
  if user is logged on{
    output deletable tags for user to view
  }
  else{
    output solely viewable tags
  }
}

function image_details(image_record){
  if user is logged on{
    output image record in class 'imgRecord' with deleting and other logged in user privileges
  }
  else{
    output image record in class 'imgRecordlogout' with only privileges of non-logged in user
  }
}

function get_extension(image_id){
  returns image extension
}

```

Example:
```
function is_user_logged_in() {
  if user is logged in, return true
  otherwise, return false
}

// Show logout, only if user is logged in.
if user is logged in (is_user_logged_in()) then
  show logout link
else
  show login link
end
```


## Database Query Plan

[Plan your database queries. You may use natural language, pseudocode, or SQL.]


```
Search for tags:
SELECT * FROM images WHERE id IN (SELECT DISTINCT image_id FROM image_tags WHERE tag_id IN (SELECT id FROM tags WHERE tag_name LIKE '%' || :searchval || '%'))

All Images:
SELECT * FROM images;

Selecting User who made tags:
SELECT user_id FROM images WHERE id IN (SELECT DISTINCT image_id FROM image_tags WHERE id=:imagetag)

Deleting Tags:
DELETE FROM image_tags WHERE id=:deletetag

get tag ids for an images:
SELECT id FROM tags WHERE id IN (SELECT tag_id FROM image_tags WHERE image_id=:id)

inserting new tag relation:
INSERT INTO 'image_tags'(tag_id, image_id) VALUES (:includetag, :imageid);

Selecting all tagnames:
SELECT tag_name FROM tags

Creating New Tag:
INSERT INTO tags(tag_name) VALUES (:newtag);

Inserting New Image:
INSERT INTO images(user_id, extension, bio) VALUES (:user_id, :extension, :bio);

Deleting Image:
DELETE FROM images WHERE id=:deleteimage

Keeping Referential Integrity in Tags Table:
DELETE FROM image_tags WHERE image_id=:deleteimage
```


# Project 3, Milestone 2 - Gallery and User Access Controls

## Issues & Challenges

[Tell us about any issues or challenges you faced while trying to complete milestone 2. 2-4 sentences/bullet points]
One of the main changes i faced was how to view a single image looking at how i implemented my site. I solved this problem by setting the value of my submit button to the images id so that when an image was clicked using the submit buttons value i could pick the right image, since all images would have the same submit button.

# Final Submission: Complete & Polished Website

## Reflection

[Take this time to reflect on what you learned during this assignment. How have you improved since starting this class? 2-4 sentences]

This assignment though challenging showed me how far i had come. I learnt about login and logout procedures through my implementation of log in with some help from Kyle. Also, I got a lot more familiar with sql. Learning how to include a lot of SQL queries side by side. Since, starting this class with very little PHP experience, I believe i am coming out very well-seasoned able to implement a functional site for a club and with the tools to substantially improve what else i can accomplish.
