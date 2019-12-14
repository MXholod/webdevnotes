<template>
    <div class="card card-default float-left col-sm-12 col-md-6 col-lg-4 col-xl-6" style="height:200px; background-color: rgba(132,128,238,0.5);">
        <div class="card-header text-center">
            Server side JS scripts
        </div>
        <div class="card-body overflow-auto accept_replace">
            <ul class="paths-list">
                <li v-for="(file,index) in incomingData" 
                    :key="index"
                    class="paths-list__item"
                    ref="liItem"
                >
                    <span>{{file.path}}</span>
                    <span class="paths-list__arrow"
                          @click="toPathDBs(index)"
                    > 
                        <i style="color:#211D9F;font-size:30px;margin-top:-3px;" class="fas fa-caret-square-right"></i>
                    </span>
                </li>
            </ul>
            <div :class="showHideDialogBox" class="accept_replace__block_hide">
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
                dataPreparedFiles:{}
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
                //First time click
                if(typeof(this.highlightedItem.current) === "undefined"){
                    this.highlightedItem.current = ind;
                    this.$refs.liItem[this.highlightedItem.current].style.backgroundColor = "#7D7ADB";
                }else{//Each other time
                    this.highlightedItem.old = this.highlightedItem.current;
                    this.$refs.liItem[this.highlightedItem.old].style.backgroundColor = "#CBCAE6";
                    this.highlightedItem.current = ind;
                    this.$refs.liItem[this.highlightedItem.current].style.backgroundColor = "#7D7ADB";
                }
                //Show YES/NO buttons
                this.showDialogBox = false;
            }
        },
        //Transfer the prepared data by Event Bus
        toDBPathsComponent:function(event){
            //Reset color
            this.$refs.liItem[this.highlightedItem.current].style.backgroundColor = "#CBCAE6";
            this.showDialogBox = true;
            //Delete current elementfrom the array
            let transferObj = this.incomingData.splice(this.currentIndex,1);
                this.dataPreparedFiles.model_id = transferObj[0].model_id; 
                this.dataPreparedFiles.model = transferObj[0].model; 
                this.dataPreparedFiles.path = transferObj[0].path; 
                this.dataPreparedFiles.h_f = transferObj[0].h_f;
                this.dataPreparedFiles.letter = transferObj[0].letter;
            //Use Event Bus
            EventEmitter.$emit("dataToDB",this.dataPreparedFiles);
            //
            //Reset index
            this.currentIndex = 0;
        },
        toRefuseDBPathsComponent:function(event){
            this.showDialogBox = true;
        }
    },
    computed:{
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
                //console.log("From dbs ",data);
                this.incomingData.unshift({
                    path : data.path,
                    model_id : data.model_id,
                    model : data.model,
                    h_f : data.h_f,
                    letter : data.letter
                });
            }
        });
    }
}
</script>
<style lang="scss" scoped>
.paths-list{
    list-style-type:none;
    .paths-list__item{
        border:1px solid #000;
        margin-top:5px;
        padding-left:5px;
        width:100%;
        background-color:#CBCAE6;
        position:relative;
        .paths-list__arrow{
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
    bottom:0px;
    left:0px;
    right:0px;
    background-color:rgba(0,0,0,0.7);
    .accept_replace__header{
        text-align:center;
        background-color:rgba(255,255,255,1);
    }
    .accept_replace__navigation{
        margin:20px; 
        %temp{
            display:inline-block;
            width:60px;
            height:30px;
            font-size:12px;
            padding:5px;
        }
        .accept_replace_agree{
            @extend %temp;
            &:active{
                background-color:#8DE6CD;
            }
            &:hover{
                background-color:#8DE6CD;
            }
        }
        .accept_replace_deny{
            @extend %temp;
            &:active{
                background-color:#7D7ADB;
            }
            &:hover{
                background-color:#7D7ADB;
            }
        }
    }
}
</style>