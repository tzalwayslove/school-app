/**
 * Created by Administrator on 2017/11/30.
 */
fabu = Vue.component('chengji', function (success, error) {
    axios.get("/public/tpl/chengji.html").then(function (res) {
        success({
            template: res.data,
            props: ['user', 'user_name', 'account'],
            data() {
                return {
                    jiazai: true,
                    chengji: [],
                    jige: [],
                    bujige: [],
                    selected: '',
                    options: [],

                }
            },
            computed: {
                GPA: function () {
                    xuefenjidian = 0;
                    xuefen = 0;
                    chengji = [];
                    for (i = 0, len = this.chengji.length; i < len; ++i) {
                        this.chengji[i].xuefen = Number(this.chengji[i].xuefen);
                        this.chengji[i].jidian = Number(this.chengji[i].jidian);
                        xuefenjidian += this.chengji[i].xuefen * this.chengji[i].jidian;

                        if(!this.inArray(chengji , this.chengji[i].kechengbianhao)){
                            chengji.push(this.chengji[i].kechengbianhao);
                            xuefen += this.chengji[i].xuefen;
                        }
                    }

                    return xuefen > 0
                        ? (xuefenjidian / xuefen).toFixed(2)
                        : 0;
                }
            },
            methods: {
                changePage: function () {
                    if(this.selected == ''){
                        return ;
                    }
                    if (this.selected == 'all') {
                        window.location.href = '/wx/chengji_all?user=' + this.user
                    } else {
                        this.jiazai = true;
                        this.getData();
                    }
                },
                inArray: function(arr, item){
                    for (var i = 0, len = arr.length; i < len; ++i) {
                        if(item == arr[i]){
                            return true;
                        }
                    }
                    return false;
                },
                getData: function () {
                    $this = this;
                    axios.get("/api/chengji?user=" + this.user + '&xueqi='+this.selected).then(function (res) {
                        $this.jiazai = false;
                        if (res.data.result.code == 0) {
                            alert(res.data.result.message || '获取失败!');
                        } else {
                            $this.chengji = res.data.chengji;
                            console.log($this.chengji);

                            $this.jige = $this.chengji.filter(function (item) {
                                return Number(item.jidian) != 0;
                            });

                            $this.bujige = $this.chengji.filter(function (item) {
                                return Number(item.jidian ) == 0;
                            });
                        }
                    });
                }
            },


            mounted: function () {
                $this = this;

                axios.get("/wx/getChengjiOptions?user=" + this.user).then(function (res) {
                    res = res.data;
                    if (res.result.code == 1) {
                        $this.options = res.options;
                    } else {
                        alert('请求数据失败，请重试！');
                    }
                });
                this.getData();

            }
        });
    });
});