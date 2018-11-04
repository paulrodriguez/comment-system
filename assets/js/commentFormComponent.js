Vue.component('comment-form', {
	data: function () {
	  return {
	    content: '',
	    author: ''
	  }
	},

	props:['parent_id','level','hierarchy'],



	methods: {
		resetform() {
			this.content='';
			this.author='';
		},
		addComment() {
			app.addComment(this.content,this.author,this.parent_id,this.level,this.hierarchy,this);
		}
	},

	template: '<div v-bind:class="{\'comment-form\':true}">'+

		'<div v-bind:class="{\'input-group mb-3\':true}">'+
		'<input type="text" placeholder="Name" v-model="author" v-bind:class="{\'form-control\':true}" />'+
		'</div>'+

		'<div v-bind:class="{\'input-group mb-3\':true}">'+
			'<textarea maxlength="500" v-model="content" v-bind:class="{\'form-control\':true}"></textarea>'+
		'</div>'+
		'<p>500 char. max. no HTML allowed</p>'+
		'<div v-bind:class="{\'input-group mb-3\':true}">'+
			'<button type="submit" v-bind:class="{\'btn btn-success\':true}" v-on:click="addComment">Submit</button>'+
		'</div>'+
	'</div>'
});
