{% extends "base.html" %}

{% block title %}Registration{% endblock %}

{% block body %}

<h2>Registration form</h2>
    <form id="form-register" action="/home/submitRegistration" method="post">
        <div class="form-group">
            <label class="control-label" for="firstname">First Name</label>
            <input type="text" name="firstname" id="firstname" class="form-control" required />
        </div>
        <div class="form-group">
            <label class="control-label" for="lastname">Last Name</label>
            <input type="text" name="lastname" id="lastname" class="form-control" required/>
        </div>
        <div class="form-group">
            <label class="control-label" for="dob">Date of birth</label>
            <input type="text" name="dob" id="dob" class="form-control" required/>
        </div>
        <div class="form-group">
            <label class="control-label" for="email">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" required/>
        </div>
        <!-- =============================== -->
            <input type="hidden" name="token" value="{{ token }}"/>
        <div class="form-group">
            <button id="submit-register" type="submit" class="btn btn-primary btn-submit">Submit</button>
        </div>
    </form>


{% endblock %}