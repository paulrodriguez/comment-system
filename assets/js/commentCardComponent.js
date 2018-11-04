Vue.component('comment-card', {
  data: function () {
	  return {

	  }
	},
props:['content','author','created_at'],
template: '<div v-bind:class="{\'card\':true}">'+
'<div v-bind:class="{\'card-body\':true}">'+
  '<h5 v-bind:class="{\'card-title\':true}">{{ this.author }}</h5>'+
  '<h6 v-bind:class="{\'card-subtitle mb-2 text-muted\':true}">{{ moment(this.created_at).format(\'MMM Do, YYYY @ h:mm a\')}}</h6>'+
  '<p v-bind:class="{\'card-text\':true}"> {{ this.content }}</p>'+
'</div>'+
'</div>'

});
