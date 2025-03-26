<?php
include('header.php');
?>

<html>
<div class="container">
        <main role="main" class="pb-3">
           
<h1>Departments</h1>

<p>
    <a href="{}">Create New</a>
</p>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Budget</th>
            <th>Start Date</th>
            <th>Instructors</th>
            <th>Courses</th>
        </tr>
    </thead>
    <tbody>
        <!-----
     {% if departments %}
        {% for department in departments %}
             <tr> 
                <td> {{ department_name }} </td> 
                <td> {{ department_budget }} </td> 
                <td> {{ department_start_date }} </td> 
                <td>  </td> 
                <td>  </td> 
                <td> 
                    <a href="">Edit</a> | 
                    <a href="">Details</a> | 
                    <a href="">Delete</a> 
                </td>
            </tr> 
            </tbody>
        </table> 
        </main> 
        </div> 

        {% endfor %}
     {% else %}
        <h2>No Departments currently in the system</h2>
     {% endif %}
      !----->
    </tbody>
</table>

        </main>
    </div>
</html>

<?php
include('footer.php');
?>