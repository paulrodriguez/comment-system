Vue.component('comment-list', {
	data: function() {
		return {
			show_subcomments: false,
			show_reply_form: false,
			reply_text: 'Write a Reply',
			view_subcomments_text: 'View Replies'
		}
	},

	methods: {
		toggleReplyForm() {
			this.show_reply_form = !this.show_reply_form;
			if(this.show_reply_form==true) {
				this.reply_text = 'Hide';
			} else {
				this.reply_text = 'Write a Reply';
			}
		},
		toggleRepliesList() {
			this.show_subcomments = !this.show_subcomments;
			if(this.show_subcomments == true) {
				this.view_subcomments_text = 'Hide Replies';
			} else {
				this.view_subcomments_text = 'View Replies';
			}
		}
	},

	props:['content','author','parent_id','created_at','hierarchy','level','children','is_last'],


	template: '<div v-bind:class="{\'comment-wrapper\':true,\'last\':is_last}"> '+
	'<comment-card v-bind:content="this.content" v-bind:author="this.author" v-bind:created_at="this.created_at"></comment-card>'+

	'<div v-bind:class="{\'subcomments\':true,\'last\':is_last}">'+
			'<a href="javascript:void(0);" role="button" v-on:click="this.toggleReplyForm" v-if="this.level < 2"'+
				' v-bind:class="{\'btn\':true, \'btn-dark\':show_reply_form}">{{this.reply_text}}</a>'+

			'<comment-form v-bind:parent_id="this.parent_id" '+
				'v-bind:level="parseInt(this.level)+1" v-bind:hierarchy="this.hierarchy" '+
				'v-if="this.level < 2" v-show="this.show_reply_form"></comment-form>'+

				'<div v-bind:class="{\'subcomment-wrapper\':true,\'last\':is_last}">'+
					'<a href="javascript:void(0);" role="button" v-if="this.children.length>0"'+
						' v-on:click="this.toggleRepliesList"'+
						' v-bind:class="{\'btn\':true, \'btn-dark\':show_subcomments}">{{ this.view_subcomments_text }}'+
					'</a>'+
					'<div v-show="this.show_subcomments">'+
						'<comment-list v-for="(comment,index) in children" '+
							'v-bind:parent_id="comment.id" v-bind:level="comment.level" ' +
							'v-bind:hierarchy="hierarchy + \',\' + comment.id"' +
							'v-bind:created_at="comment.created_at" v-bind:author="comment.author" '+
							'v-bind:is_last="index==children.length-1" '+
							'v-bind:content="comment.content" v-bind:children="comment.children"></comment-list>'+
					'</div>'+
				'</div>'+
		'</div>'
});
