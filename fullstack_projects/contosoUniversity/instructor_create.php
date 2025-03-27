<?php
include('header.php');
?>
<div class="container">
        <main role="main" class="pb-3">
            

<h1>Create</h1>

<h4>Instructor</h4>
<hr>
<div class="row">
    <div class="col-md-8">
        <form action="" method="post" novalidate="novalidate">
            
            <div class="form-group">
                <label class="control-label" for="LastName">Last Name</label>
                <input class="form-control" type="text" data-val="true" data-val-length="The field Last Name must be a string with a maximum length of 50." data-val-length-max="50" data-val-required="The Last Name field is required." id="LastName" maxlength="50" name="LastName" value="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAfBJREFUWAntVk1OwkAUZkoDKza4Utm61iP0AqyIDXahN2BjwiHYGU+gizap4QDuegWN7lyCbMSlCQjU7yO0TOlAi6GwgJc0fT/fzPfmzet0crmD7HsFBAvQbrcrw+Gw5fu+AfOYvgylJ4TwCoVCs1ardYTruqfj8fgV5OUMSVVT93VdP9dAzpVvm5wJHZFbg2LQ2pEYOlZ/oiDvwNcsFoseY4PBwMCrhaeCJyKWZU37KOJcYdi27QdhcuuBIb073BvTNL8ln4NeeR6NRi/wxZKQcGurQs5oNhqLshzVTMBewW/LMU3TTNlO0ieTiStjYhUIyi6DAp0xbEdgTt+LE0aCKQw24U4llsCs4ZRJrYopB6RwqnpA1YQ5NGFZ1YQ41Z5S8IQQdP5laEBRJcD4Vj5DEsW2gE6s6g3d/YP/g+BDnT7GNi2qCjTwGd6riBzHaaCEd3Js01vwCPIbmWBRx1nwAN/1ov+/drgFWIlfKpVukyYihtgkXNp4mABK+1GtVr+SBhJDbBIubVw+Cd/TDgKO2DPiN3YUo6y/nDCNEIsqTKH1en2tcwA9FKEItyDi3aIh8Gl1sRrVnSDzNFDJT1bAy5xpOYGn5fP5JuL95ZjMIn1ya7j5dPGfv0A5eAnpZUY3n5jXcoec5J67D9q+VuAPM47D3XaSeL4AAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
                <span class="text-danger field-validation-valid" data-valmsg-for="LastName" data-valmsg-replace="true"></span>
            </div>
            <div class="form-group">
                <label class="control-label" for="FirstMidName">First Name</label>
                <input class="form-control" type="text" data-val="true" data-val-length="First name cannot be longer than 50 characters." data-val-length-max="50" data-val-required="The First Name field is required." id="FirstMidName" maxlength="50" name="FirstMidName" value="">
                <span class="text-danger field-validation-valid" data-valmsg-for="FirstMidName" data-valmsg-replace="true"></span>
            </div>
            <div class="form-group">
                <label class="control-label" for="HireDate">Hire Date</label>
                <input class="form-control" type="date" data-val="true" data-val-required="The Hire Date field is required." id="HireDate" name="HireDate" value="">
                <span class="text-danger field-validation-valid" data-valmsg-for="HireDate" data-valmsg-replace="true"></span>
            </div>
            <div class="form-group">
                <label class="control-label" for="OfficeAssignment_Location">Office Location</label>
                <input class="form-control" type="text" data-val="true" data-val-length="The field Office Location must be a string with a maximum length of 50." data-val-length-max="50" id="OfficeAssignment_Location" maxlength="50" name="OfficeAssignment.Location" value="">
                <span class="text-danger field-validation-valid" data-valmsg-for="OfficeAssignment.Location" data-valmsg-replace="true">
            </span></div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <table>
                        <tbody><tr>
                                    </tr><tr>
                                    <td>
                                        <input type="checkbox" name="selectedCourses" value="1">
1   Hand to hand combat
                                    </td>
                                    <td>
                                        <input type="checkbox" name="selectedCourses" value="2">
2   333
                                    </td>
                                    <td>
                                        <input type="checkbox" name="selectedCourses" value="4">
4   uuu
                                    </td>
                            </tr>
                        </tbody></table>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" value="Create" class="btn btn-primary">
                </div>
            <input name="__RequestVerificationToken" type="hidden" value="CfDJ8DhsjiwTP-lAjG6LFEmaiMNDrG4mSSRHtHMzqC77m8OjipJPV_DMb83kJ9Nob9n_LJsdq6Pj_bxAnRx69cF9I-FmiiZcWBIYuMFVqRgT0LZqm0sIjqOZc2xuDdK2BpGUulF8YWJbCOhty72QKVoMkO8"></form>
    </div>
</div>

<div>
    <a href="{% url 'instructors' %}">Back to List</a>
</div>


        </main>
    </div>
<?php
include('footer.php');
?>