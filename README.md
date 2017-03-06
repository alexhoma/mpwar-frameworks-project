Symfony Framework Project
========================

Blog visits tracker project based on the Symfony Standard Edition.


Initialize
--------------

Open your terminal and run these commands:

```
$ git clone https://github.com/alexhoma/mpwar-frameworks-project.git
$ composer update
```

Bundles:
  * **BlogBundle** - Very simple blog example to create posts to test our visits tracker.
    It only has one entity called Post, and you can only create posts (not delete or update them).
    
  * **TrackerBundle** - This is our visits tracker. 
  It takes the User Agent via javascript and posts it to our aplication.
  
To track posts visits you must include the following JS snippet on your post detail view:


```
{% include("TrackerBundle:Tracker:tracker.html.twig") %}
```

It comes pre-configured with the following bundles:

  * **FrameworkBundle** - The core Symfony framework bundle
