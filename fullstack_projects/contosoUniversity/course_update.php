<?php
include('header.php');
?>

<div class="container">
        <main role="main" class="pb-3">
            

<h1>Course Edit</h1>

<hr>
<div class="row">
    <div class="col-md-4">
        <form action="" method="post" novalidate="novalidate">
            

            <div class="form-group">
                <label class="control-label" for="Title">Title</label>
                <input class="form-control" type="text" data-val="true" data-val-length="The field Title must be a string with a minimum length of 3 and a maximum length of 50." data-val-length-max="50" data-val-length-min="3" id="Title" maxlength="50" name="Title" value="{{course.course_title}}">
                <span class="text-danger field-validation-valid" data-valmsg-for="Title" data-valmsg-replace="true"></span>
            </div>
            <div class="form-group">
                <label class="control-label" for="Department">Department</label>
                <select class="form-control" data-val="true" data-val-required="The DepartmentID field is required." id="DepartmentID" name="DepartmentID" value="{{course.course_department}}">
                <option value="">-- Select Department --</option>
                <option value="ART">ART</option>
                <option value="SCIENCE">SCIENCE</option>
                <option value="ENGINEERING">ENGINEERING</option>
                <option value="MATHEMATICS">MATHEMATICS</option>
                </select>
                <span class="text-danger field-validation-valid" data-valmsg-for="DepartmentID" data-valmsg-replace="true">
            </span></div>
            <div class="form-group">
                <input type="submit" value="Save" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>

<div>
    <a href="{% url 'courses' %}">Back to List</a>
</div>


        </main>
    </div>

<?php
include('footer.php');
?>