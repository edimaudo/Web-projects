<?php
include('header.php');
?>

<html>
<div class="container"> 
<main role="main" class="pb-3">
<h2>Courses</h2>

<p> <a href="">Create New</a> </p> 
<table class="table"> 
	<thead> 
		<tr> 
			<th> Number </th>
			<th> Title </th> 
			<th> Department </th> 
			<th></th> 
		</tr> 
	</thead> 
	<tbody>
        <!----
		{% if courses %}
	 		{% for course in courses %}
			 <tr> 
			 	<td> {{ course.id }} </td> 
			 	<td> {{ course.course_title }} </td> 
			 	<td> {{ course.course_department_name }} </td> 
			 	<td>  </td> 
			 	<td> 
					<a href="">Edit</a> | 
					<a href="">Details</a> | 
					<a href="">Delete</a> 
				</td>
			</tr> 
			</tbody>
			{% endfor %}
            !---->
		</table> 
		</main> 
		</div> 
       <!---- 
     {% else %}
     	<h2>No Courses currently in the system</h2>
     {% endif %}
     !---->
</html>

<?php
include('footer.php');
?>