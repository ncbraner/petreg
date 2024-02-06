# Docupet Registration

## Welcome to Docupet Registration

### Getting Started

#### Prerequisites
- Laravel 10.41
- Vue 3.4.14
- Docker

#### Setup Instructions
1. Clone or download the repository: [Docupet](https://github.com/ncbraner/docupet)
2. Run composer install: ```composer install```
3. Run the setup command:
```php artisan project:setup```

This command will update composer and npm, boot up the docker container, run database migrations, and seed the database.

4. To start the project later, use: ```php artisan project:start```
5. To stop the project, use ```php artisan docker:down```

### About The Project

This project simulates a real-world work project broken down into agile stories. Key features include:
- Pet type selection (Cat/Dog) and breed selection from a database.
- Responsive form design and a table for displaying registered pets.
- Use of HTML5, Tailwind, Vue.js, and Laravel.

### Requirements and Design
- Tailwind CSS integrated via CDN.
- HTML5 structure with SEO and accessibility considerations.
- Vue.js powers the form, focusing on simplicity.
- MVC(S) design pattern with an emphasis on SOLID principles.

### Docker Environment
- Ensures compatibility across different environments.

### Bonus Points
- Utilization of Vue3 and Laravel.
- Project progress demonstrated through git commits aligning with agile stories.
- Docker environment.


### Few backstories

I treated this as you would a normal work project, so before I put fingers to keyboards, I tried to break the challenge into stories as you would in a agile environment.  
For the most part you will see that in the git commits.  

One of the reasons I have some database seeds is that I did create a crude breeds table.  It contains 20 breeds for dogs and 20 for cats.  
There was not too much thought into this table. I just wanted to have the breeds stored within the database and not hard coded within the component

The last thing to mention is that I also added a quick table to show you what pets are already registered with a click of the “ show my pets” button.   
That as helpful for a few reasons.  The first reason was it allows you to see the data as you’re going without having to pull open a database tool.   
The second reason was to meet some responsive requirements.  The form itself was pretty easy to make responsive if you follow mobile first practices.   
Tables are a bit trickier so we uses some tailwind breakpoints to drop columns and shrink her down. There is only a single step adjustment but the demonstration is available now.

The app is using tailwind.  We just pulled that in via CDN within the blade template.
We did focus on html5. 
```
The <!DOCTYPE html> declaration is present at the start of the document, which is required in HTML5.  
The <html> tag includes the lang attribute, which is good for accessibility and SEO.  
The <head> section includes the necessary meta tags such as <meta charset="UTF-8"> and <meta name="viewport" content="width=device-width, initial-scale=1.0">.
The <title> tag is present, which is important for SEO and usability.  
The <body> tag is used to wrap the body content of the page.  
The form inputs have associated <label> tags, which is good for accessibility.  
The CSS and JavaScript are linked correctly in the <head> section.  
```
I did go through and add a header and footer as well.  I did not take the time to make a point of using all the HTML5 tags but wanted to make a point to show I understand HTML5 structures.

When a pet is correctly saved, you will get a 201. Likewise, We have a few constraints on the database so if you attempt to break them.  You will get a 422.

### Components
The form is powered by Vue.js.  In this instance, we only have one component as it’s a simple form.  One thing I want to recognize that is in practice,  
some parts of this form could be their own components if the application called for it.  Listing breeds for example.  
For this challenge however, I leaned more on simplicity vs solving tomorrow’s issue.

### Solid and Design
a S to MVC(S). standing for service.  A quick run-down is that Routers are dumb as they should be.  No logic is in a router outside of responses to the front end.   
The controller is the orchestrator.  It should call out to services that do the logic and pass results around as needed.  
Services do the hard work of computing outputs.  They connect to models/repository to get the data needed for their work.  This app is simple so there isn’t a service.  
I just wanted to explain my general concept to Solid and MVC architecture.



