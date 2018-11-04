
var app = new Vue({
  el: '#app',
  data: {
  	comments:[],
  },
  methods: {

  	addComment(content,author,parent_id,level,hierarchy,form) {
      var oThis = this;
  		var params = new FormData();
  		params.append('content', content);
  		params.append('author', author);
  		params.append('parent_id', parent_id);
  		params.append('level', level);

  		axios.post(BASE_URL+'addComment',params).then(function(res) {
  			r = res.data;
        if(r.success==false) {
          alert(r.error);
          return;
        }
        // reset form content
        form.content = '';
        form.author = '';
        oThis.addCommentToList(r.comment,hierarchy);

  		});

  	},

    addCommentToList(comment,hierarchy) {

      // this means that a comment will be added at level 0 (not a child of another comment)
      if(hierarchy==0 || hierarchy==undefined || hierarchy == null) {
        comment['children'] = new Array();
        this.comments.unshift(comment);

        return;
      }
      var comment_list = this.comments;
      var i = 0;
      var parent = 0;
      hierarchy_arr = hierarchy.split(',');


      while(i < hierarchy_arr.length) {
        for(var idx in comment_list) {
          if(comment_list[idx]['id']==hierarchy_arr[i]) {
            comment_list = comment_list[idx]['children'];
            break;
          }
        }
        i += 1;
      }

      comment['children'] = new Array();
      comment_list.unshift(comment);
    },

  	getAllComments() {
  		var oThis = this;
  		axios.get(BASE_URL+'getAllComments').then(function(res) {
  			oThis.comments = res.data.comments;
  		});
  	}
  },

  beforeMount() {
  	this.getAllComments();
  }
})
