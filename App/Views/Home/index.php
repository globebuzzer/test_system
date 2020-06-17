{% extends "base.html" %}

{% block title %}Home{% endblock %}

{% block body %}

<h1>Welcome</h1>
<p>Hello {{ name }}, this is just a quick demo</p>
<p>To register click <a href="register.php">here</a></p>
<ul>
    {% for colour in colours %}
    <li>{{ colour }}</li>
    {% endfor %}
</ul>

{% endblock %}