<template>
    <div class="card card-default float-left col-sm-12 col-md-6 col-lg-6 col-xl-6" style="height:200px; background-color: rgba(132,128,238,0.5);">
        <div class="card-header text-center">
            Server side JS scripts
        </div>
        <div class="card-body overflow-auto accept_replace">
            <ul class="paths-list">
                <li v-for="(file,index) in incomingData" 
                    :key="index"
                    ref="liItem"
                    class="paths-list__item"
                    :class="{paths_list__item_default : !file.highlited, paths_list__item_highlited : file.highlited }"
                >
                    <span>{{file.path}}</span>
                    <span class="paths-list__arrow"
                          @click="toPathDBs(index)"
                    > 
                        <i class="fas fa-caret-square-right paths-list__arrow-icon"></i>
                    </span>
                </li>
            </ul>
            <div :class="showHideDialogBox" class="accept_replace__block_hide" :style="setHeightDialogBox">
                <p class="accept_replace__header">Move the item to the neighbor section</p>
                <div class="accept_replace__navigation">
                    <button v-on:click.prevent="toDBPathsComponent" class="accept_replace_agree">
                        YES
                    </button>
                    <button @click.prevent="toRefuseDBPathsComponent" class="accept_replace_deny">
                        NO
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { EventEmitter } from "../../app.js";
export default {
    props:["files"],
    data() {
        return {
                incomingData:[],
                currentIndex:0,
                highlightedItem:{current:undefined,old:undefined},//Index for highlighted item
                showDialogBox:true,
                dataPreparedFiles:{},
                liHeight:0
            };
    },
    methods:{
        prepareIncomingData: function(){
            this.files.forEach((currentValue, index, array)=>{
                var obj = {};
                    obj.path = currentValue.path;
                    obj.model_id = currentValue.id;
                    obj.model = currentValue.model;
                    obj.h_f = 0;
                    obj.letter = "H";
                    obj.highlited = false;
                this.incomingData.push(obj);
            });
        },
        getType: function(value){
           var regex = /^\[object (\S+?)\]$/;
           var matches = Object.prototype.toString.call(value).match(regex) || [];
           return (matches[1] || 'undefined').toLowerCase();
        },
        //Prepared data
        toPathDBs:function(ind){
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
        toDBPathsComponent:function(event){
            this.showDialogBox = true;
            //Delete current elementfrom the array
            let transferObj = this.incomingData.splice(this.currentIndex,1);
                this.dataPreparedFiles.model_id = transferObj[0].model_id; 
                this.dataPreparedFiles.model = transferObj[0].model; 
                this.dataPreparedFiles.path = transferObj[0].path; 
                this.dataPreparedFiles.h_f = transferObj[0].h_f;
                this.dataPreparedFiles.letter = transferObj[0].letter;
                this.dataPreparedFiles.highlited = transferObj[0].highlited;
            //Use Event Bus
            EventEmitter.$emit("dataToDB",this.dataPreparedFiles);
            //Reset index
            //this.currentIndex = 0;
        },
        toRefuseDBPathsComponent:function(event){
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
            return { height: heightAll};
        },
        showHideDialogBox(){
            return {accept_replace__block : !this.showDialogBox};//False at once when loaded
        }
    },
    created() {
        //Prepare data
        this.prepareIncomingData();
        //Use Event Bus
        EventEmitter.$on("dataToFiles",data => {
            if(this.getType(data) == "object"){
                //Reset highlited color - all to FALSE
                this.resetHighlightedItem();
                this.incomingData.unshift({
                    path : data.path,
                    model_id : data.model_id,
                    model : data.model,
                    h_f : data.h_f,
                    letter : data.letter,
                    highlited : data.highlited
                });
                //console.log("From dbs ",data);
            }
        });
    },
    mounted() {
        //Get value from CSS when app was loaded first time, the biggest value is right:-125px;
        let cssPropRight = window.getComputedStyle(this.$refs.liItem[0],null).getPropertyValue("height");
        this.liHeight = parseInt(cssPropRight); 
    }
}
</script>
<style lang="scss" scoped>
/* All devices up to 480px*/
.paths-list{
    list-style-type:none;
    .paths_list__item_default{
        background-color:#CBCAE6;
    }
    .paths_list__item_highlited{
        background-color:#7D7ADB;
    }
    .paths-list__item{
        font-size:13px;
        border:1px solid #000;
        margin-top:5px;
        padding-left:5px;
        padding-right:20px;
        width:120%;
        position:relative;
        left:-15px;
        .paths-list__arrow{
            .paths-list__arrow-icon{
                color:#211D9F;
                font-size:25px;
                margin-top:-3px;
            }
            padding:0px;
            position:absolute;
            right:0px;
            top:0px;
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
/* Extra Small devices (phones, 480px and up)*/
@media only screen and (min-width: 480px) { 
    .paths-list{
        
        .paths-list__item{
            font-size:14px;
            border:1px solid #000;
            margin-top:5px;
            padding-left:5px;
            padding-right:25px;
            width:100%;
            position:relative;
            left:0px;
            padding-left:5px;
            position:relative;
            .paths-list__arrow{
                .paths-list__arrow-icon{
                    font-size:27px;
                    margin-top:-3px;
                }
            }
        }
    }
    .accept_replace__block{
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
    .paths-list{
        
        .paths-list__item{
            font-size:15px;
            border:1px solid #000;
            margin-top:5px;
            padding-left:5px;
            padding-right:25px;
            width:100%;
            position:relative;
            left:0px;
            padding-left:5px;
            position:relative;
            .paths-list__arrow{
                .paths-list__arrow-icon{
                    font-size:30px;
                    margin-top:-3px;
                }
            }
        }
    }
    .accept_replace__block{
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
    .paths-list{
        
        .paths-list__item{
            font-size:14px;
            border:1px solid #000;
            margin-top:5px;
            padding-left:5px;
            padding-right:25px;
            width:120%;
            position:relative;
            left:-15px;
            padding-left:5px;
            position:relative;
            .paths-list__arrow{
                .paths-list__arrow-icon{
                    font-size:27px;
                    margin-top:-3px;
                    margin-right:-1px;
                }
            }
        }
    }
    .accept_replace__block{
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
    .paths-list{
        
        .paths-list__item{
            font-size:16px;
            border:1px solid #000;
            margin-top:5px;
            padding-left:5px;
            padding-right:0px;
            height:26px;
            width:100%;
            position:relative;
            left:0px;
            padding-left:5px;
            position:relative;
            .paths-list__arrow{
                .paths-list__arrow-icon{
                    font-size:30px;
                    margin-top:-2px;
                    margin-right:-1px;
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
/* Extra large devices (large desktops, 1200px and up)*/
@media only screen and (min-width: 1200px) {
    .paths-list{
        
        .paths-list__item{
            font-size:16px;
            border:1px solid #000;
            margin-top:5px;
            padding-left:5px;
            padding-right:0px;
            height:26px;
            width:100%;
            position:relative;
            left:0px;
            padding-left:5px;
            position:relative;
            .paths-list__arrow{
                .paths-list__arrow-icon{
                    font-size:30px;
                    margin-top:-3px;
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