{% extends 'base.html' %}

{% block search %}
<!-- Search form -->
    <form id="searchform" method="post" action="{{ url_for('index') }}" accept-charset="utf-8">
        <input type="text" placeholder="Search.." name="search">
    </form>
{% endblock %}


{% block content %}
  <div class="grid-100">
    <ul class="minerals__container">
      {% for mineral in minerals %}
          <li class="minerals__item">
              <a href="/detail/{{mineral.id}}">{{mineral.name}}</a>
          </li>
        {% endfor %}
      </ul>
    </div>
{% endblock %}


{% block footer %}
    <div class="minerals__random">
      <a class="minerals__anchor" href="{{ url_for('random') }}">Show random mineral</a>
    </div>
{% endblock %}

