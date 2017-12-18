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
                        list: [],
                        articelData : {},
                        jiahao: true,
                        pinglun_input: false,
                        comment: ''
                    }
                },
                methods:{
                    addpinglun(){
                        this.showConvert();
                    },
                    showConvert(){
                        this.jiahao = !this.jiahao;
                        this.pinglun_input = !this.pinglun_input;
                    },
                    send(){
                        let articel_id = this.articelData.id;
                        let $this = this;

                        axios.post('wx/addComment', {
                            id: articel_id,
                            content: this.comment
                        }).then(function(res){
                            if(res.data.result.code == 1){
                                $this.list.push(res.data.comment);
                                $this.comment = '';
                            }else{
                                alert(res.data.result.message || '评论失败');
                            }
                        });
                        this.showConvert();
                    },
                    setZan: function (item) {
                        zan = !!!item.zanLog ? 1 : -1;
                        id = item.id;
                        axios.post('wx/comment_zan', {
                            id: id,
                            zan: zan
                        }).then(function (res) {
                            item.zan = res.data.comment.zan ;
                        });
                        item.zanLog = !!!item.zanLog;
                    },
                    hide_input(){
                        this.jiahao = true;
                        this.pinglun_input = false;
                    }
                },
                mounted: function () {
                    let id =this.$route.params.id;
                    let $this =this;
                    axios.get('wx/comment/'+ id).then(function(res){
                        console.log(res);
                        $this.articelData = res.data.data;
                        $this.list = res.data.data.get_comment;
                        if($this.list.length == 0){

                        }
                    });
                }
            }
        );
    });
});