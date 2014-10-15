Aplus API
=========
[This API usage reference is available at github](https://github.com/yuan3y/OpenSnap/blob/master/API%20Usage.md )

Create User
-----------
**POST method:** http://php54-opensnap.rhcloud.com/users/
 this will create a user.
### fields to pass in:
* email, password, name, gender, age

gender is 0 or 1, age is number

### sample success:
```json
{"user_id":"3","email":"admin2@example.com","name":"Admin Aplus","gender":"0","age":"21"}
```
### sample failure: 
```json
{"error":"Duplicate entry 'admin1@example.com' for key 'email'"}
```

Get User Detail
---------------
**GET method:** http://php54-opensnap.rhcloud.com/users/$user_id
e.g. http://php54-opensnap.rhcloud.com/users/3
 this will ask for all details about the user with this id.
### sample success:
```json
{"user_id":"3","email":"admin2@example.com","name":"Admin Aplus","gender":"0","age":"21"}
```
### sample failure:
```json
{"error":"user does not exist , error"}
```

Update User
------------
**POST method:** http://php54-opensnap.rhcloud.com/users/$user_id
e.g. http://php54-opensnap.rhcloud.com/users/3
 this will update all details about the user with this id.
### sample success:
```json
{"user_id":"1","email":"user1@hotmail.com","name":"user1","gender":"0","age":"21"}
```
###sample faliure:
```json
{"error":"Invalid old password "}
```

Check Login
-----------
**POST method:** http://php54-opensnap.rhcloud.com/checklogin/
 this checks if the email & password match
### fields to pass in:
 * email, password

### sample success:
```json
{"user_id":"10","email":"admin5@example.com","name":"Admin Aplus","gender":"0","age":"25"}
```
### sample failure:
```json
{"error":"login does not match , error"}
```

CreateEntry
---------------------------
**POST method:** http://php54-opensnap.rhcloud.com/entries/
 this will create a entry.
 based on user_id and product_id
### fields to pass in:
* user_id,product_id,entry_name,manufacturer,packaging_type,rating_ease,rating_safety,rating_reseal,rating_overall,comment

### sample success:
```json
{"entry_id":"60","user_id":"3","product_id":"12227","timestamp":"2014-09-30 00:01:33","image":null,"entry_name":"product 13337","manufacturer":"nestle","packaging_type":"package type 3","rating_ease":"1","rating_safety":"2","rating_reseal":"2","rating_overall":"2","comment":"update t form website"}
```

Update entry
----------------------------------
**POST method:** http://php54-opensnap.rhcloud.com/entries/
 this will update a entry.
 base on user_id and product_id
### fields to pass in:
* entry_id,entry_name,manufacturer,packaging_type,,rating_ease,rating_safety,rating_reseal,rating_overall,comment

### sample success:
```json
{"entry_id":"60","user_id":"3","product_id":"12227","timestamp":"2014-09-30 00:01:33","image":null,"entry_name":"product 13337","manufacturer":"nestle","packaging_type":"package type 3","rating_ease":"1","rating_safety":"2","rating_reseal":"2","rating_overall":"2","comment":"update from website"}
```

Get A particular Entry's Details using proudct_id and user_id
-----------------------------------------------------------
**GET method:** http://php54-opensnap.rhcloud.com/entries/
### fields to pass in:
* user_id,product_id

### sample success:
```json
{"entry_id":"3","user_id":"1","product_id":"1001","timestamp":"2014-09-28 10:11:11","image":"upload\/3_1411913471.jpg","entry_name":"","rating_ease":"3","rating_safety":"3","rating_reseal":"3","rating_overall":"3","comment":"test null  Img Col via DBserver"}
```
### sample faliure:
```json
{"error":"Entries Not Found"}
```

Get A particular Entry's Image URL
-----------------------------------
**GET method:** http://php54-opensnap.rhcloud.com/entries/:entry_id/image/
### fields to pass in:
* *none*

### sample success:
```json
{"entry_id":"3","user_id":"1","product_id":"1001","timestamp":"2014-09-26 20:49:29","image":"upload\/3_1411778969.jpg","entry_name":"","rating_ease":"3","rating_safety":"3","rating_reseal":"3","rating_overall":"3","comment":"test null Img Col via DBserver"}
```
### sample faliure:
```json
{"error":"image based on entry_id` - 4 not found , error"}
```

Upload a particular Entry's Image
-----------------------------------
**POST method:** http://php54-opensnap.rhcloud.com/entries/:entry_id/image/

**Note: image upload should happen _ONLY_ after an entry is created**
### fields to pass in:
* image_file (as a file)

### sample success:
```json
{"entry_id":"3","image":"upload\/3_1411778969.jpg"}
```
### sample failure:
```json
{"error":"`entry_id` - 4 does not exist"}
```

Delete an Entry 
----------------------------------
**POST method:** http://php54-opensnap.rhcloud.com/entries/:entry_id/delete/
### fields to pass in:
* *none*

### sample success:
```json
{"success":"entry  7 has been successfully deleleted"}
```
### sample failure:
*none*

* there's no failure condition. We simply don't care. *


Display Journal
-----------------------------------
**POST method:** http://php54-opensnap.rhcloud.com/users/:user_id/entries/
### fields to pass in:
* *none*

### sample success:
```json
[{"entry_id":"2","user_id":"2","product_id":"8801062636358","timestamp":"2014-10-02 03:52:16","image":"upload\/2_1412236336.jpg","name":"Random Alvin","manufacturer":"Kraft","packaging_type":"Bag","rating_ease":"3","rating_safety":"4","rating_reseal":"2","rating_overall":"3","comment":"Alvin very bad!!!"},{"entry_id":"3","user_id":"2","product_id":"8851019110127","timestamp":"2014-10-02 04:22:32","image":"upload\/3_1412238152.jpg","name":"Pocky Biscuit Sticks","manufacturer":"Nestle","packaging_type":"Box","rating_ease":"5","rating_safety":"3","rating_reseal":"2","rating_overall":"3.3333333333333335","comment":"okay la...."}]
```
### sample failure:
```json
""
```

Browse Product
---------------------
**GET method:** http://php54-opensnap.rhcloud.com/browse/
### fields to pass in:
* manufacturer, packaging_type

### sample success 1: when there is no input
```json
[{"product_id":"8888915298062","name":"cute girl","manufacturer":"Kraft","packaging_type":"Bag","image":"upload\/4_1412238099.jpg","no_of_raters":"1","avg_rating":"4"},{"product_id":"8801062636358","name":"gs","manufacturer":"Kraft","packaging_type":"Bag","image":"upload\/1_1412243384.jpg","no_of_raters":"3","avg_rating":"3.3333333333333335"},{"product_id":"8851019110127","name":"Pocky Biscuit Sticks","manufacturer":"Nestle","packaging_type":"Box","image":"upload\/3_1412238152.jpg","no_of_raters":"1","avg_rating":"3"},{"product_id":"8885001890186","name":"herbal drink","manufacturer":"Kraft","packaging_type":"Bottle","image":"upload\/6_1412238270.jpg","no_of_raters":"1","avg_rating":"3"},{"product_id":"1234567890","name":"product4","manufacturer":"manufacturer00004","packaging_type":"Box","image":"","no_of_raters":"2","avg_rating":"2.5"},{"product_id":"0","name":"gs","manufacturer":"Kraft","packaging_type":"Bag","image":"","no_of_raters":"0","avg_rating":"0"},{"product_id":"123456","name":"produc1","manufacturer":"manufacturer00001","packaging_type":"Box","image":"","no_of_raters":"0","avg_rating":"0"}]
```
### sample success 2: only got manufacturer input
```json
[{"product_id":"0","name":"gs","manufacturer":"Kraft","packaging_type":"Bag","image":"","no_of_raters":"0","avg_rating":"0"},{"product_id":"8801062636358","name":"gs","manufacturer":"Kraft","packaging_type":"Bag","image":"upload\/1_1412243384.jpg","no_of_raters":"3","avg_rating":"3.3333333333333335"},{"product_id":"8885001890186","name":"herbal drink","manufacturer":"Kraft","packaging_type":"Bottle","image":"upload\/6_1412238270.jpg","no_of_raters":"1","avg_rating":"3"},{"product_id":"8888915298062","name":"cute girl","manufacturer":"Kraft","packaging_type":"Bag","image":"upload\/4_1412238099.jpg","no_of_raters":"1","avg_rating":"4"}]
```
### sample success 3: only got packaging_type input
```json
[{"product_id":"8885001890186","name":"herbal drink","manufacturer":"Kraft","packaging_type":"Bottle","image":"upload\/6_1412238270.jpg","no_of_raters":"1","avg_rating":"3"}]
```
### sample success 4: Both inputs
```json
[{"product_id":"0","name":"gs","manufacturer":"Kraft","packaging_type":"Bag","image":"","no_of_raters":"0","avg_rating":"0"},{"product_id":"8801062636358","name":"gs","manufacturer":"Kraft","packaging_type":"Bag","image":"upload\/1_1412243384.jpg","no_of_raters":"3","avg_rating":"3.3333333333333335"},{"product_id":"8888915298062","name":"cute girl","manufacturer":"Kraft","packaging_type":"Bag","image":"upload\/4_1412238099.jpg","no_of_raters":"1","avg_rating":"4"}]
```
### sample failure:// when database has no match
```json
""
```