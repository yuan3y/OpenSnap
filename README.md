A PHP Mysql server API for OpenSnap
====================================
This is an ongoing work for our 2014 Semester 1's CZ2006 Software Engineering project in Nanyang Technological University, Singapore.

All codes are our own original work unless otherwise indicated.

Feel free to fork this project & host it on your own server.

We haven't figured out how to write a database installation script, 
so find `php54.sql`, change line 20 (`php54`) to your database name, 
then manually import it to your database. 
If you are hosting on your own server (other than on Openshift), you need to create a upload folder also.

Do note that this API is meant to be simple and hastle-free for the school project, 
the password is NOT encrypted at all. Do change that when you decide to fork it for real-world use.

[This API usage reference is available at github](https://github.com/yuan3y/OpenSnap/blob/master/API%20Usage.md )

[Live Demo Site](http://php54-opensnap.rhcloud.com/) You are welcome to use this live site, however it is provided "as is", without any guarantee of availibility or security among others. 

Environment
---
Our web stack uses [Openshift](http://www.openshift.com/)'s environment, PHP 5.4, MySQL 5.5.

We have also done local testing with PHP 5.5.12 and MySQL 5.6.17.