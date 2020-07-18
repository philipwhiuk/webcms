# Website CMS

This project is aimed at providing a functional website CMS:

## Aims

There are a few goals:

* Ensure that 99.9% of the site is maintainable by someone with no technical skills
* Provide mobile-ready user experience
* Build in better GDPR user request support (automated user data download, deletion support)
* Build in better GDPR-aware communication
* Use modern software design standards


## Design

### Data Flow

The core platform is built around a page rendering pipeline and an API pipeline:

* User makes request to website.com/site/home/edit
* The URL is rewritten from /site/home/edit to /site/?page=home/edit
* We take a user's page request: ?page=home/edit
* The first part is treated as the page name: 'home'
* Subsequent parts are treated as information for the module controlling the page
* The page itself provides some information to the module: 'item/1/view'
* The module is then called to resolve the request based on the information for the page: 'item/1/edit'
* We check permissions for that request: 'content/item/1/edit'
* We retrieve any blocks attached the page
* We render the page's main component: 'content/item/1/edit' and the blocks into template data
* We display the templates for the page, which calls the main display and block displays in the right places

The API pipeline is simpler, a request for a/b/c is directed to a with b/c as information
* Currently the API pipeline is not very RESTful - all requests are POSTs

### GDPR Personal Data Storage

#### Core Data

* user - Login Details
* user_login_history - Login Attempts
* payment_transaction - Payment Log



## Modules

System Modules

* block
* page
* module
* theme
* user
* error

Core Modules

* content
* menu
* gallery
* news
* uploads

Communications

* mailing_list
* email

e-Commerce

* payment
* store

Social

* facebook


## Implementation Progress

* API
  * Outstanding:
    * Move to RESTful API
    * Permissions
    * Better handling of SQL errors
* Block
  * Add, Edit, Delete, List View, Admin View
  * Outstanding:
    * Page Block Visibility Admin
    * Better 'action selection'
* Content:
  * Add, Edit, Delete, List View, Admin View
  * Share Hook
  * Outstanding:
    * Replace Delete with Form
    * New "Content Page" (page name, menu structure)
    * Description
    * Keywords
    * Author
    * Drafts
* Facebook
  * Share Button for Content
  * Outstanding:
    * Share buttons for News, Events
    * Facebook Login
    * Post to Facebook
* Form
  * Outstanding:
    * Move required JS logic out of Theme
    * Good example delete form
    * Better date entry
    * Hybrid-select autocomplete option
    * Image resize
    * Client-side validation of mandatory fields
* Content Macros
* Gallery
  * Gallery Item management
* Instagram
  * Not Started
* News:
  * News Categories
  * Publish End Date
  * Latest News should only show articles that are within publish dates
  * RSS Feed
  * Social Integration
  * Emails
* Mailing List
  * Not started
* Menu
  * Main Menu Block View, Side Menu Block View
* Modules
  * Module List Done
  * Outstanding:
    * Module dependencies
    * Module installation
    * Module removal
    * Module upgrade
* Page:
  * Add, Edit, Delete, List View, Admin View
  * Outstanding:
    * New 'X' Page
    * Replace forms with Form
    * Better 'action selection'
* Permissions
  * Introduce User Roles
  * User Permissions Management
  * "View As" Tool
* Pinterest
  * Not started
* Theme:
  * Partial Default theme
  * Outstanding
    * Templates for Modules
    * Move JS imports to Modules
* Twitter
  * Not started
* User:
  * Login / Logout
  * Outstanding
    * Register
    * GDPR
* Payment Flow
  * Not Started
* Admin
  * Started proper Admin UI
  * Outstanding:
    * Dashboards ("Outstanding Requests")
* Uploads
  * Not started
