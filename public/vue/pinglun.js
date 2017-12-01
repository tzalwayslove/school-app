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
                        axios.post('wx/addComment', {
                            id: articel_id,
                            content: this.comment
                        }).then(function(res){
                            if(res){
                                this.list.push(res.data.comment)
                            }else{
                                alert('评论失败');
                            }
                        });
                        this.showConvert();
                    },
                },
                mounted: function () {
                    let id =this.$route.params.id;
                    let $this =this;
                    axios.get('wx/comment/'+ id).then(function(res){
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