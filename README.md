

<img src="https://calderawp.com/public/cwp-content/uploads/2015/01/calderawp-logo.png" >

# Caldera Metaplate: Front-end for Calera Metaplate, Handlebars.php-based custom field templating and display system.
#### By <a href="https://CalderaWP.com" title="CalderaWP: Transform Your WordPress Experience">CalderaWP</a>

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Desertsnowman/caldera-metaplate/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Desertsnowman/caldera-metaplate/?branch=master)

Automatic metadata &amp; custom field templates for WordPress


### Important RE: Dependencies / PHP versions
If you clone this repo from GitHub, you must run `composer update` or you will be missing the required dependencies, which is most of the plugin. You can download a built package @todo or from WordPress.org(soon).

Also this plugin requires PHP 5.3 or later. If you're running anything less than 5.4 you really should upgrade for security and performance reasons.

### Setting Up A New Metaplate
The Caldera Metaplate menu is located in the WordPress Appearance menu. From there you can create a new Metaplate by clicking the "Add New" button. This will open a modal where you can give your metaplate a name and slug. Then you will be taken to the metaplate editor, starting with the "Setup" tab.

In the "Setup" tab, you can edit the name and slug. In addition you have the following options:

* Page Types: Whether this metaplate should be used for single post view, archive view or both.
* Placement: Whether this metaplate should be used in before, after or in place of the post content.
* Post Types: Which post types to use this metaplate for.

<img src="http://calderawp.com/public/cwp-content/uploads/2015/02/metaplate-settings.png" >
### Using The Tempalting System
To output any text field in your template, use the name of the field, surrounded by two brackets. For example, if your field was called "age_of_kitten", you would use `{{age_of_kitten}}`. We can even show the post content using `{{content}}`.

### Arrays
If your field contains an array, for example an image field, you can traverse into the array keys. For example, with a field called "picture" that contained a key "url", you would use `{{picture.url}}` to get the URL for the image. 

### Loops
Thanks to Handlebars helpers you can easily loop through Advanced Custom Fields repeater fields, Custom Field Suite Loop fields and similar fields. For example, if Caldera Metaplate is being used to show an Advanced Custom Fields loop field called "kittens" that has two sub fields. One "label" is a text field, and the other "image" is an image field. To show each item in the loop field, we use an each loop:

```html
	<h3>{{kitten_subheading}}</h3>
	<ul>
	{{#each kittens}}
		<li>
			<h5>{{label}}</h5>
			<img src="{{image.url}}" alt="{{img.alt}}" />
		</li>

	{{/each}}
	</ul>
```

### Conditionals
Caldera Metaplate also provides other helpers, such as `if`. With `if` you can check if a field has a value, and `is`, which also you to check if a field has a certain value. This next example, expands upon the each loop form above, but checks if the current post has any entries in the "kittens" field before outputting the header and the loop:

 ```html
    {{#if kittens}}
        <h3>{{kitten_subheading}}</h3>
        <ul>
        {{#each kittens}}
            <li>
                <h5>{{label}}</h5>
                <img src="{{image.url}}" alt="{{img.alt}}" />
            </li>
     
        {{/each}}
        </ul>
    {{/if}}
```

The `if` helper prevents unneeded markup and headers for posts without certain data. The `is` helper will allow you to run a comparison on a field. For example if you have an events custom post type, with two fields, one a boolean field called "public" and another called "location" and only wanted to show the location for public events. You could use the `is` helper:

```html
    {{#is public value=true}}<p>This event will be held at: {{location}}</p>{{/is}}
```

### License, Copyright etc.
Copyright 2014-2015 [CalderaWP LLC](https://CalderaWP.com), [David Cramer](http://digilab.co.za/) & [Josh Pollock](http://JoshPress.net).

Licensed under the terms of the [GNU General Public License version 2](http://www.gnu.org/licenses/gpl-2.0.html) or later. Please share with your neighbor.
    
   


