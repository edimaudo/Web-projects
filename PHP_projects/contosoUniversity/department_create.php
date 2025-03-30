<?php
include('header.php');
?>

<div class="container">
        <main role="main" class="pb-3">
            

<h2>Create</h2>

<h4>Department</h4>
<hr>
<div class="row">
    <div class="col-md-4">
        <form action="/ContosoUniversity/Departments/Create" method="post" novalidate="novalidate">
            
            <div class="form-group">
                <label class="control-label" for="Name">Name</label>
                <input class="form-control" type="text" data-val="true" data-val-length="The field Name must be a string with a minimum length of 3 and a maximum length of 50." data-val-length-max="50" data-val-length-min="3" id="Name" maxlength="50" name="Name" value="">
                <span class="text-danger field-validation-valid" data-valmsg-for="Name" data-valmsg-replace="true"></span>
            </div>
            <div class="form-group">
                <label class="control-label" for="Budget">Budget</label>
                <input class="form-control" type="text" data-val="true" data-val-number="The field Budget must be a number." data-val-required="The Budget field is required." id="Budget" name="Budget" value="">
                <span class="text-danger field-validation-valid" data-valmsg-for="Budget" data-valmsg-replace="true"></span>
            </div>
            <div class="form-group">
                <label class="control-label" for="StartDate">Start Date</label>
                <input class="form-control" type="date" data-val="true" data-val-required="The Start Date field is required." id="StartDate" name="StartDate" value="">
                <span class="text-danger field-validation-valid" data-valmsg-for="StartDate" data-valmsg-replace="true"></span>
            </div>
            <div class="form-group">
                <label class="control-label" for="InstructorID">InstructorID</label>
                <select class="form-control" id="InstructorID" name="InstructorID">
                    <option value="">-- Select Administrator --</option>
                <option value="2">Schrute, Dwight</option>
</select>
            </div>
            <div class="form-group">
                <input type="submit" value="Create" class="btn btn-default">
            </div>
        </form>
    </div>
</div>

<div>
    <a href="{% url 'departments' %}">Back to List</a>
</div>


        </main>
    </div>

<?php
include('footer.php');
?>