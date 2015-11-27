#Octopus Cruncher

##Business Needs

Octopus Cruncher is a piece of software designed to allow WordPress users build a single CSS file containing all of the resources added to enque_styles.

##Key Users

This plugin targets is use to regular people with no coding experience.


##Personas

Emma Strong is owns a WordPress website, she uses several plugins to add extra features to her custom theme. 

In total Emma's website loads 50 CSS-files per visit.

##User Goals

**Emma Strong**

- List all of the styles used on her website
- Automatically order the list of styles
- Select which styles are to be compressed
- Indicate which styles are listed as requiste
- Auto nesting of styles
- Allow sorting of Styles
- Allow naming of Styles
- Check button to indicate weather or not to use the cruncher
- Mark style as ignored
- Un-mark style as ignored


##Features

1. Gather Styles Information
2. Select and Re-ordering of styles
3. Compress Styles
4. Manage plugin activation

##User Stories

1. Emma activates OC to enhance the performance of her website, when she goes to the **Settings Page** shw notices the style list is empty. The plugin displays the message "Please Visit your Home Page to load the styles into the list" with a link to the **Front Page** of the website. 

When Emma clicks the link a **blank tab** opens her website **Front Page**.

The following things happen in the background

- A filter lists all of the styles enqueued and creates an entry for every local resource
- A second process indicates which registered scripts are marked as a dependency
- Every style entry requires an order of inclussion
- A hidden script make a call to an AJAX endpoint to indicate styles have been loaded
- The **Settings Page** updates 
- A message Window pops up Offering to take Emma to the **Settings Page**
 
2. On the **Settings Page** Emma drags on of the styles to the very bottom of the list so the rules are applied last.

3. Once all styles are ordered as Emma wants them she presses the Compress button. A progress bar appears to indicate when the bundle will be ready. 

4. Emma detects there's an error on the layout of her website, she goes to the **Settings Page** clicks on the checkbox "Use crunched file"
 
