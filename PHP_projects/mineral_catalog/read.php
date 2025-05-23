{% extends 'base.html' %}

{% block content %}
    <div class="grid-100 mineral__container">
      <h1 class="mineral__name">{{mineral.name}}</h1>
      <div class="mineral__image-bg">
        <img class="mineral__image" src="/static/img/{{ mineral.name }}.jpg">
        <p class="mineral__caption">{{mineral.img_caption}}</p>
      </div>
      <div class="mineral__table-container">
        <table class="mineral__table">
          <tr>
            <td class="mineral__category">Category</td>
            <td>{{mineral.category}}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="minerals__random">
      <a class="minerals__anchor" href="{{ url_for('index') }}">Home</a>
  </div>
{% endblock %}