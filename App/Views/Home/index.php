{% extends "base.html" %}

{% block title %}Home{% endblock %}

{% block body %}

<h2>Welcome</h2>
<p>Hello {{ name }}, this is just a quick demo</p>
<p>To register click <a href="home/register">here</a></p>
<ul>
    {% for colour in colours %}
    <li>{{ colour }}</li>
    {% endfor %}
</ul>

{% endblock %}