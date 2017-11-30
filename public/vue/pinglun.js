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
                        data : {},
                        list: []
                    }
                },
                mounted: function () {
                    let id =this.$route.params.id;
                    let $this =this;
                    axios.get('wx/comment/'+ id).then(function(res){
                        $this.articel = res.data.data;
                        $this.list = res.data.data.get_comment;
                        console.log(res.data);
                        if($this.list.get_comment.length == 0){
                            alert('还没有人评论');
                        }
                    });
                }
            }
        );
    });
});