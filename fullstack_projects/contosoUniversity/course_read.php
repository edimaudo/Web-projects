<?php
include('header.php');
?>

<div class="container">
        <main role="main" class="pb-3">
<h1>Course Details</h1>

<div>
    <hr>
    <dl class="row">
        <dt class="col-sm-2">
            Title
        </dt>
        <dd class="col-sm-10">
            {{course.course_title}}
        </dd>
        <dt class="col-sm-2">
            Department
        </dt>
        <dd class="col-sm-10">
            {{course.course_department_name }}
        </dd>
        
            </tbody></table>
        </dd>
    </dl>
</div>
<div>
    <a href="{% url 'courses_edit' pk=course.pk %}">Edit</a> |
    <a href="{% url 'courses' %}">Back to List</a>
</div>

        </main>
    </div>

<?php
include('footer.php');
?>