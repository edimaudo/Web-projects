<?php
include('header.php');
?>

<html>
<div class="container">
        <main role="main" class="pb-3">
            

<h2>Instructors</h2>

<p>
    <a href="">Create New</a>
</p>
<table class="table">
    <thead>
        <tr>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Hire Date</th>
            <th>Office</th>
            <th>Courses</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <!----
                 {% if Instructors %}
        {% for instructor in instructors %}
             <tr> 
                <td> {{ instructor_first_name }} </td> 
                <td> {{ instructor_last_name }} </td> 
                <td> {{ instructor_hire_date }} </td> 
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
        <h2>No Instructors currently in the system</h2>
     {% endif %}

     !---->

    </tbody>
</table>



        </main>
    </div>
</html>

<?php
include('footer.php');
?>