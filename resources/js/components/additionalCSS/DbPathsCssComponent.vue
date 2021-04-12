<template>
    <div class="card card-default float-left col-sm-12 col-md-6 col-lg-6 col-xl-6" style="height:200px;background-color: rgba(0,0,255,0.1);">
        <div class="card-header text-center">
            Стили для этого ресурса
        </div>
        <div class="card-body overflow-auto accept_replace">
            <ul class="paths-list">
                <li v-for="(dataItem,index) in incomingData"
                    :key="dataItem.id"
                    ref="liItem"
                    class="paths-list__item"
                    :class="{paths_list__item_default : !dataItem.highlited, paths_list__item_highlited : dataItem.highlited }"
                >
                    <span class="paths-list__arrow"
                          @click="toPathFiles(index)"
                    >
                        <i class="fas fa-caret-square-left paths-list__arrow-icon"></i>
                    </span>
                    <span class="paths-list__text">{{dataItem.path_css}}</span>
                    <input type="hidden" name="idsCss[]" :value="dataItem.id" />
                </li>
            </ul>
            <div :class="showHideDialogBox" class="accept_replace__block_hide" :style="setHeightDialogBox">
                <p class="accept_replace__header">Move the item to the neighbor section</p>
                <div class="accept_replace__navigation">
                    <button v-on:click.prevent="toFilePathsComponent" class="accept_replace_agree">
                        YES
                    </button>
                    <button @click.prevent="toRefuseFilePathsComponent" class="accept_replace_deny">
                        NO
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { EventEmitterCss } from "../../app_main_admin.js";
import route from './../../routesExtractFromJson';
export default {
    props:["dbpaths"],
    data(){
        return {
            incomingData:[],//Incoming data
            currentIndex:0,
            highlightedItem:{current:undefined,old:undefined},//Index for highlighted item
            showDialogBox:true,//Show hide dialog box
            dataPreparedFiles:{},//Prepared data before send,
            liHeight:0
        };
    },
    methods:{
        //We prepare incoming data before they are used.
        prepareIncomingData: function(){
            this.dbpaths.forEach((currentValue, index, array)=>{
                //Set new Reactiv property 'highlited' to the Object, initial with default value
                Vue.set(currentValue,'highlited',false);
                //Set new Reactiv property 'panelHidden' to the Object, initial with default value
                Vue.set(currentValue,'panelHidden',0);
                this.incomingData.push(currentValue);
            });
        },
        getType: function(value){
           var regex = /^\[object (\S+?)\]$/;
           var matches = Object.prototype.toString.call(value).match(regex) || [];
           return (matches[1] || 'undefined').toLowerCase();
        },
        //Prepared data
        toPathFiles:function(ind){
            //First time click
            if(this.incomingData.length > 0){
                this.currentIndex = ind;
                //Reset highlited color - all to FALSE
                this.resetHighlightedItem();
                //Change color by click - current to TRUE
                this.incomingData[this.currentIndex].highlited = !this.incomingData[this.currentIndex].highlited;
                //Show YES/NO buttons
                this.showDialogBox = false;
            }
        },
        //Transfer the prepared data by Event Bus
        toFilePathsComponent:function(event){
            this.showDialogBox = true;
             //Delete current elementfrom from the array and then get it
            let transferObj = this.incomingData.splice(this.currentIndex,1);
                this.dataPreparedFiles.model_id = transferObj[0].styleable_id;
                this.dataPreparedFiles.model = transferObj[0].styleable_type;
                this.dataPreparedFiles.path = transferObj[0].path_css;
                this.dataPreparedFiles.highlited = transferObj[0].highlited;
                this.dataPreparedFiles.panelHidden = transferObj[0].panelHidden;
            //Save Vue context
            let that = this;
            //Call axios method 'delete' to call Laravel method 'destroy($id)' to delete row in DB
            //axios.delete(`http://webdevnotes/admin/styles/${transferObj[0].id}` ,{
            axios.delete(route("admin.styles.destroy",[transferObj[0].id]) ,{
                //_method: 'delete'
                headers:{
                        'Content-type':'application/x-www-form-urlencoded'
                    }
                })
              .then(function (response) {
                    //If Response is good from the server we get an ID from MySQL.There's smth to delete.
                    if(response.data.id > 0){
                        //Use Event Bus
                        EventEmitterCss.$emit("dataToFiles",that.dataPreparedFiles);
                    }else{
                        //console.log(response);
                    }
              })
              .catch(function (error) {
                    console.log(error);
            });
        },
        toRefuseFilePathsComponent:function(event){
            this.showDialogBox = true;
        },
        resetHighlightedItem:function(){
            //Reset highlited color - all to FALSE
            this.incomingData.forEach(function(item, i, arr) {
                if(item.highlited == true){
                    item.highlited = false;
                }
            });
        }
    },
    computed:{
        setHeightDialogBox(){
            let paddingTop = (this.incomingData.length * 5);
            let all;
                if(this.incomingData.length <= 2){
                    all = (2 * this.liHeight) + paddingTop + this.liHeight;
                }else{
                    all = (this.incomingData.length * this.liHeight) + paddingTop + this.liHeight;
                }
            let heightAll = all+"px";
            return { height: heightAll };
        },
        showHideDialogBox(){
            return {accept_replace__block : !this.showDialogBox};//False at once when loaded
        }
    },
    created(){
        //Prepare data
        this.prepareIncomingData();
        //Use Event Bus
        EventEmitterCss.$on("dataToDB",data => {
            if(this.getType(data) == "object"){
                //Reset highlited color - all to FALSE
                this.resetHighlightedItem();
                this.incomingData.unshift({  //Vue.set();//or this.$set(array,ind,value)
                    path_css : data.path,
                    styleable_id : data.model_id,
                    styleable_type : data.model,
                    highlited: data.highlited,
                    id: data.id,
                    panelHidden: data.panelHidden
                });
            }
        });
    },
    mounted() {
        if(this.dbpaths.length > 0){
            //Get a LI height when app was loaded first time.
            let cssPropLiHeight = window.getComputedStyle(this.$refs.liItem[0],null).getPropertyValue("height");
            this.liHeight = parseInt(cssPropLiHeight);
        }
    },
    updated(){
        //Get a LI height when app was loaded first time.
        if(this.$refs.liItem[0]){
            let cssPropLiHeight = window.getComputedStyle(this.$refs.liItem[0],null).getPropertyValue("height");
            this.liHeight = parseInt(cssPropLiHeight);
        }else{
            this.liHeight = 0;
        }
    }
}
</script>
<style lang="scss" scoped>
/* All devices up to 480px*/
.card-header{font-size: 12px;}
.paths-list{
    list-style-type:none;
    .paths_list__item_default{
        background-color:#ECC9D6;
    }
    .paths_list__item_highlited{
        background-color:#DB93AC;
    }
    .paths-list__item{
        overflow:hidden;
        font-size:13px;
        border:1px solid #000;
        margin-top:5px;
        padding-left:5px;
        padding-right:20px;
        width:120%;
        position:relative;
        left:-15px;
        .paths-list__arrow{
            padding:0px;
            position:absolute;
            left:0px;
            top:0px;
            .paths-list__arrow-icon{
                color:#9F1D74;
                font-size:25px;
                margin-top:-3px;
            }
        }
        .paths-list__text{
            padding-left:25px;
            display:block;
        }
        .paths-list__header-footer{
            font-size:11px;
            height:25px;
            width:100px;
            position:absolute;
            top:0px;
            right:-95px;
            background-color:#EBB1D2;
            z-index:2;
            border-left:5px solid #000;
            border-color: #76415F;
            padding-left:5px;
            .paths-list__letter{
                width:15px;
                height:18px;
                box-sizing:content-box;
                padding:2px 0px 0px 4px;
                display:inline-block;
                position:absolute;
                top:-1px;
                left:-20px;
                font-size:11px;
                font-weight:bold;
                color:#fff;
                background-color:#76415F;
                border-top-left-radius:15px;
                border-bottom-left-radius:15px;
                border:1px solid #000;
                border-right:none;
            }
            & > label input[type="radio"]{
                position:relative;
                top:3px;
                left:0px;
            }
        }
    }
}
.accept_replace{
    position:relative;
}
.accept_replace__block_hide{
    display:none;
}
.accept_replace__block{
    display:block;
    position:absolute;
    z-index:3;
    top:0px;
    left:0px;
    width:100%;
    /*bottom:0px;
    right:0px;*/
    background-color:rgba(0,0,0,0.7);
    .accept_replace__header{
        font-size:13px;
        text-align:center;
        background-color:rgba(255,255,255,1);
    }
    .accept_replace__navigation{
        margin:20px;
        @mixin buttons(){
            display:inline-block;
            height:25px;
            font-size:11px;
            padding:3px 4px;
        }
        .accept_replace_agree{
            @include buttons();
            &:active{
                background-color:#8DE6CD;
            }
            &:hover{
                background-color:#8DE6CD;
            }
        }
        .accept_replace_deny{
            @include buttons();
            &:active{
                background-color:#7D7ADB;
            }
            &:hover{
                background-color:#7D7ADB;
            }
        }
    }
}
@media only screen and (min-width: 480px) {
    .card-header{font-size: 13px;}
    .paths-list{

        .paths-list__item{
            font-size:14px;
            margin-top:5px;
            padding-left:5px;
            padding-right:20px;
            width:100%;
            position:relative;
            left:0px;
            .paths-list__arrow{
                padding:0px;
                position:absolute;
                left:0px;
                top:0px;
                .paths-list__arrow-icon{
                    font-size:27px;
                    margin-top:-3px;
                }
            }
            .paths-list__text{
                padding-left:25px;
                display:block;
            }
            .paths-list__header-footer{
                font-size:12px;
                height:25px;
                width:105px;
                position:absolute;
                top:0px;
                right:-100px;
                z-index:2;
                border-left:5px solid #000;
                padding-left:5px;
                .paths-list__letter{
                    width:15px;
                    height:20px;
                    box-sizing:content-box;
                    padding:2px 0px 0px 4px;
                    top:-1px;
                    left:-20px;
                    font-size:12px;
                    border-top-left-radius:15px;
                    border-bottom-left-radius:15px;
                }
                & > label input[type="radio"]{
                    position:relative;
                    top:3px;
                    left:0px;
                }
            }
        }
    }
    .accept_replace__block{
        z-index:3;
        top:0px;
        left:0px;
        width:100%;
        .accept_replace__header{
            font-size:14px;
        }
        .accept_replace__navigation{
            margin:20px;
            @mixin buttons(){
                display:inline-block;
                height:25px;
                font-size:12px;
                padding:3px 5px;
            }
            .accept_replace_agree{
                @include buttons();
            }
            .accept_replace_deny{
                @include buttons();
            }
        }
    }
}
/* Small devices (landscape phones, 576px and up)*/
@media only screen and (min-width: 576px) {
    .card-header{font-size: 13px;}
    .paths-list{

        .paths-list__item{
            font-size:15px;
            margin-top:5px;
            padding-left:5px;
            padding-right:20px;
            width:100%;
            position:relative;
            left:0px;
            .paths-list__arrow{
                padding:0px;
                position:absolute;
                left:0px;
                top:0px;
                .paths-list__arrow-icon{
                    font-size:30px;
                    margin-top:-3px;
                }
            }
            .paths-list__text{
                padding-left:25px;
                display:block;
            }
            .paths-list__header-footer{
                font-size:13px;
                height:25px;
                width:110px;
                position:absolute;
                top:0px;
                right:-105px;
                z-index:2;
                border-left:5px solid #000;
                padding-left:5px;
                .paths-list__letter{
                    width:15px;
                    height:22px;
                    box-sizing:content-box;
                    padding:2px 0px 0px 4px;
                    top:-1px;
                    left:-20px;
                    font-size:12px;
                    border-top-left-radius:15px;
                    border-bottom-left-radius:15px;
                }
                & > label input[type="radio"]{
                    position:relative;
                    top:3px;
                    left:0px;
                }
            }
        }
    }
    .accept_replace__block{
        z-index:3;
        top:0px;
        left:0px;
        width:100%;
        .accept_replace__header{
            font-size:15px;
        }
        .accept_replace__navigation{
            margin:20px;
            @mixin buttons(){
                display:inline-block;
                height:30px;
                font-size:12px;
                padding:5px;
            }
            .accept_replace_agree{
                @include buttons();
            }
            .accept_replace_deny{
                @include buttons();
            }
        }
    }
}
/* Medium devices (tablets, 768px and up)*/
@media only screen and (min-width: 768px) {
    .card-header{font-size: 13px;}
    .paths-list{

        .paths-list__item{
            font-size:14px;
            margin-top:5px;
            padding-left:5px;
            padding-right:20px;
            width:120%;
            position:relative;
            left:-15px;
            .paths-list__arrow{
                padding:0px;
                position:absolute;
                left:0px;
                top:0px;
                .paths-list__arrow-icon{
                    font-size:27px;
                    margin-top:-3px;
                }
            }
            .paths-list__text{
                padding-left:25px;
                display:block;
            }
            .paths-list__header-footer{
                font-size:12px;
                height:25px;
                width:105px;
                position:absolute;
                top:0px;
                right:-100px;
                z-index:2;
                border-left:5px solid #000;
                padding-left:5px;
                .paths-list__letter{
                    width:15px;
                    height:20px;
                    box-sizing:content-box;
                    padding:2px 0px 0px 4px;
                    top:-1px;
                    left:-20px;
                    font-size:11px;
                    border-top-left-radius:15px;
                    border-bottom-left-radius:15px;
                }
                & > label input[type="radio"]{
                    position:relative;
                    top:3px;
                    left:0px;
                }
            }
        }
    }
    .accept_replace__block{
        z-index:3;
        top:0px;
        left:0px;
        width:100%;
        .accept_replace__header{
            font-size:14px;
        }
        .accept_replace__navigation{
            margin:20px;
            @mixin buttons(){
                display:inline-block;
                height:26px;
                font-size:12px;
                padding:3px;
            }
            .accept_replace_agree{
                @include buttons();
            }
            .accept_replace_deny{
                @include buttons();
            }
        }
    }
}
/* Large devices (desktops, 992px and up)*/
@media only screen and (min-width: 992px) {
    .card-header{font-size: 14px;}
    .paths-list{

        .paths-list__item{
            font-size:16px;
            margin-top:5px;
            padding-left:5px;
            padding-right:20px;
            height:26px;
            width:100%;
            position:relative;
            left:0px;
            .paths-list__arrow{
                padding:0px;
                position:absolute;
                left:0px;
                top:0px;
                .paths-list__arrow-icon{
                    font-size:30px;
                    margin-top:-3px;
                }
            }
            .paths-list__text{
                padding-left:25px;
                display:block;
            }
            .paths-list__header-footer{
                font-size:13px;
                height:25px;
                width:110px;
                position:absolute;
                top:0px;
                right:-105px;
                z-index:2;
                border-left:5px solid #000;
                padding-left:5px;
                .paths-list__letter{
                    width:15px;
                    height:23px;
                    box-sizing:content-box;
                    padding:2px 0px 0px 4px;
                    top:-1px;
                    left:-20px;
                    font-size:12px;
                    border-top-left-radius:15px;
                    border-bottom-left-radius:15px;
                }
                & > label input[type="radio"]{
                    position:relative;
                    top:3px;
                    left:0px;
                }
            }
        }
    }
    .accept_replace__block{
        z-index:3;
        top:0px;
        left:0px;
        width:100%;
        .accept_replace__header{
            font-size:16px;
        }
        .accept_replace__navigation{
            margin:20px;
            @mixin buttons(){
                display:inline-block;
                height:30px;
                width:60px;
                font-size:12px;
                padding:5px;
            }
            .accept_replace_agree{
                @include buttons();
            }
            .accept_replace_deny{
                @include buttons();
            }
        }
    }
}
/* Extra large devices (large desktops, 1200px and up)*/
@media only screen and (min-width: 1200px) {
    .card-header{font-size: 15px;}
    .paths-list{

        .paths-list__item{
            font-size:16px;
            border:1px solid #000;
            margin-top:5px;
            padding-left:35px;
            padding-right:0px;
            height:26px;
            width:100%;
            position:relative;
            left:0px;
            padding-left:5px;
            position:relative;
            .paths-list__arrow{
                padding:0px;
                position:absolute;
                left:0px;
                top:0px;
                z-index:1;
                .paths-list__arrow-icon{
                    font-size:30px;
                    margin-top:-3px;
                }
            }
            .paths-list__text{
                padding-left:25px;
                display:block;
            }
            .paths-list__header-footer{
                height:25px;
                width:130px;
                position:absolute;
                top:0px;
                right:-125px;
                background-color:#EBB1D2;
                font-size:14.5px;
                z-index:2;
                border-left:5px solid #000;
                border-color: #76415F;
                padding-left:5px;
                .paths-list__letter{
                    width:15px;
                    height:23px;
                    box-sizing:content-box;
                    padding:2px 0px 0px 4px;
                    display:inline-block;
                    position:absolute;
                    top:-1px;
                    left:-20px;
                    font-size:12px;
                    font-weight:bold;
                    color:#fff;
                    background-color:#76415F;
                    border-top-left-radius:15px;
                    border-bottom-left-radius:15px;
                    border:1px solid #000;
                    border-right:none;
                }
                & > label input[type="radio"]{
                    position:static;
                }
            }
        }
    }
    .accept_replace__block{
        top:0px;
        left:0px;
        width:100%;
        .accept_replace__header{
            font-size:16px;
        }
        .accept_replace__navigation{
            margin:20px;
            @mixin buttons(){
                display:inline-block;
                width:60px;
                height:30px;
                font-size:12px;
                padding:5px;
            }
            .accept_replace_agree{
                @include buttons();
            }
            .accept_replace_deny{
                @include buttons();
            }
        }
    }
}
</style>
