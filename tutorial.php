<?php 
//add widget for tutorial
add_action( 'wp_dashboard_setup', 'register_my_dashboard_widget' );
    function register_my_dashboard_widget() {
    wp_add_dashboard_widget(
        'my_dashboard_widget',
        'Notes',
        'my_dashboard_widget_display'
    );
}
function my_dashboard_widget_display() {
    echo '
		<h1 style="color: red"><strong>Hello, Please find the <span style="color:black">Quick User Guide</span> on the right side.  
    <p>-> If there is any, User Guide in pdf format will be found <a href="#" target="_blank">here</a>.</p></strong></h1>
';
}
// add quick user guide
add_action( 'wp_dashboard_setup', 'my_dashboard_setup_function' );
function my_dashboard_setup_function() {
    add_meta_box( 'my_dashboard_widget2', 'Quick User Guide', 'my_dashboard_widget_function', 'dashboard', 'side', 'high' );
}
function my_dashboard_widget_function() { 
    echo ' 
    <strong><h2 style="color: red;">1. Update menu:</h2>
    <p>-> At the left side of the screen, find Appearance -> Menus</p> 
    <h2 style="color: red";>2. Update image:</h2>
    <p> -> At the left side of the screen, find Appearance -> Customize -> Carousel, Images Panel</p>
    <h2 style="color: red";>3. Update post: </h2>
    <p> -> At the left side of the screen, find Appearance -> Posts -> See the following table for information where these posts are placed. </p>
    <p>-> Post category is used to identify on which page these multiple entries are going to be placed. </p>
    Post categories: 
    <table class="table" style="border: 2px solid black";>
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Post Category</th>
          <th scope="col">Post will be placed on which page</th>      
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td style="padding-left: 18px";>Food</td>
          <td>Category page</td>        
        </tr>
        <tr>
          <th scope="row">2</th>
          <td style="padding-left: 18px";>Cooking</td>
          <td>Cooking page</td>     
        </tr>
        <tr>
          <th scope="row">3</th>
          <td style="padding-left: 18px";>Lifestyle</td>
          <td>Lifestyle page</td>      
        </tr>
        <tr>
          <th scope="row">4</th>
          <td style="padding-left: 18px";>Gallery</td>
          <td>Gallery on the footer and under Blog page</td>      
        </tr>         
      </tbody>
    </table>
    </strong>
    <p>Issues with wordpress, contact me at <a href="mailto: catzhang1@hotmail.ca">here.</a>
';
}
?>