<?php
include('header.php');
?>

<div class="container">
        <main role="main" class="pb-3">
<h1>Add Student</h1>

<hr>
<div class="row">
    <div class="col-md-4">
        <form action="" method="post" >
            {% csrf_token %}
            <div class="form-group">
                <label class="control-label" for="LastName">Last Name</label>
                <input class="form-control" type="text" data-val="true" data-val-length="The field Last Name must be a string with a maximum length of 50." data-val-length-max="50" data-val-required="The Last Name field is required." id="LastName" maxlength="50" name="LastName" value="" required="">
                <span class="text-danger field-validation-valid" data-valmsg-for="LastName" data-valmsg-replace="true"></span>
            </div>
            <div class="form-group">
                <label class="control-label" for="FirstMidName">First Name</label>
                <input class="form-control" type="text" data-val="true" data-val-length="First name cannot be longer than 50 characters." data-val-length-max="50" data-val-required="The First Name field is required." id="FirstMidName" maxlength="50" name="FirstMidName" value="" required="">
                <span class="text-danger field-validation-valid" data-valmsg-for="FirstMidName" data-valmsg-replace="true"></span>
            </div>
            <div class="form-group">
                <label class="control-label" for="EnrollmentDate">Enrollment Date</label>
                <input class="form-control" type="date" data-val="true" data-val-required="The Enrollment Date field is required." id="EnrollmentDate" name="EnrollmentDate" value="" required="">
                <span class="text-danger field-validation-valid" data-valmsg-for="EnrollmentDate" data-valmsg-replace="true"></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Create" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>

<div>
    <a href="{% url 'students' %}">Back to List</a>
</div>


</main>
</div>

<?php
include('footer.php');
?>