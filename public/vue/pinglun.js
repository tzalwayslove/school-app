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
                        console.log('addpinglun run');
                        this.showConvert();
                    },
                    showConvert(){
                        this.jiahao = !this.jiahao;
                        this.pinglun_input = !this.pinglun_input;
                    },
                    send(){
                        console.log(this.comment);
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