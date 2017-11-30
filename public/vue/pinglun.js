/**
 * Created by Administrator on 2017/11/30.
 */
pinglun = Vue.component('pinglun', function (success, error) {
    axios.get("/public/tpl/pinglun.html").then(function (res) {
        success({
                template: res.data,
                props: ['articel'],
                data(){
                    return {
                        list: []
                    }
                },
                mounted: function () {
                    let id =this.$route.params.id;
                    let $this =this;
                    axios.get('wx/comment/'+ id).then(function(res){
                        $this.list = res.data.list.get_comment;
                        if($this.list.get_comment.length == 0){
                            alert('还没有人评论');
                        }
                    });
                }
            }
        );
    });
});