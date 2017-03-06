Blog Visits Tracker
========================

Tracker application based on the Symfony Standard Edition.


Initialize
--------------

Open your terminal and run the following:

```
$ git clone https://github.com/alexhoma/mpwar-frameworks-project.git
$ composer update
```

Initialize
--------------
  * **BlogBundle** - Very simple blog example to create posts to test our visits tracker.<br>
  It only has one entity called `Post`,  and you can only create posts (not delete or update them).
    
  * **TrackerBundle** - This is our visits tracker.<br>
    It takes the User Agent via javascript and posts it to our aplication.<br>
    Has a single Entity `Record` related to `Post`.<br>
    It also has a basic dashboard to show us all recorded visits in our blog, and also shows us the visits of a concrete post.
    
  * **AlertBundle** - This bundle tells us if we have achieved a certain number of visits in our posts, sending an email with the info via SwiftMailer.<br>
  It has a listener triggered just after a visit is tracked.<br>
  By default we will recieve an email every 10, 50 and 100 visits of each post.

To track posts visits you **must** include the following JS snippet on your post detail view:

```
{% include("TrackerBundle:Tracker:tracker.html.twig") %}
```

