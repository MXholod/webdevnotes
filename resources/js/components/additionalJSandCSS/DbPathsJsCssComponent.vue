<template>
    <div class="card card-default float-left col-sm-12 col-md-6 col-lg-6 col-xl-6" style="height:200px; background-color: rgba(0,0,255,0.1);"> 
        <div class="card-header text-center">
            Database JS scripts
        </div>
        <div class="card-body overflow-auto accept_replace">
            <ul class="paths-list">
                <li v-for="(dataItem,index) in incomingData" 
                    :key="dataItem.id"
                    class="paths-list__item"
                    ref="liItem"
                >
                    <span class="paths-list__arrow"
                          @click="toPathFiles(index)"
                    > 
                        <i style="color:#9F1D74;font-size:30px;margin-top:-3px;" class="fas fa-caret-square-left"></i>
                    </span>
                    <span class="paths-list__text">{{dataItem.path_js}}</span>
                    <span 
                        @click="showHide"  
                        class="paths-list__header-footer"
                        ref="h_f"
                    >
                        <span class="paths-list__letter">{{dataItem.letter}}</span>
                        <label @click="changeLetter(index,$event)">header
                            <input type="radio" :name="'dbscripts['+index+']'" 
                               :checked="dataItem.letter == 'H'" value="0" :key="index" />
                        </label>
                        <label @click="changeLetter(index,$event)">footer
                            <input type="radio" :name="'dbscripts['+index+']'" 
                               :checked="dataItem.letter == 'F'" value="1" :key="index" />
                        </label>
                    </span>
                </li>
            </ul>
            <div :class="showHideDialogBox" class="accept_replace__block_hide">
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
import { EventEmitter } from "../../app.js";
export default {
    props:["dbpaths"],
    data(){
        return {
            incomingData:[],//Incoming data 
            currentIndex:0,
            startCss:0,//Offset for radio buttons
            highlightedItem:{current:undefined,old:undefined},//Index for highlighted item
            showDialogBox:true,//Show hide dialog box
            dataPreparedFiles:{},//Prepared data before send
        };
    },
    methods:{
        //We prepare incoming data before they are used.
        prepareIncomingData: function(){
            this.dbpaths.forEach((currentValue, index, array)=>{
                if(currentValue.header_or_footer == 0){
                    currentValue.letter = "H";
                }
                if(currentValue.header_or_footer == 1){
                    currentValue.letter = "F";
                }
                this.incomingData.push(currentValue);
            });
        },
        getType: function(value){
           var regex = /^\[object (\S+?)\]$/;
           var matches = Object.prototype.toString.call(value).match(regex) || [];
           return (matches[1] || 'undefined').toLowerCase();
        },
        //Slide a little 'header-footer' panel forward and back
        showHide:function($event){
            //Click must be only by element with a "paths-list__letter" class
            if($event.target.getAttribute('class') == "paths-list__letter"){
                let rightVal = parseInt($event.target.parentNode.style.right);
                //Do this only once. Initial value was mounted.
                if(isNaN(rightVal) && (this.startCss != 0)){
                    $event.target.parentNode.style.right = "0px";
                }else{//Attribute 'style' is already exists
                    if(rightVal != 0){
                        $event.target.parentNode.style.right = "0px";
                    }else{
                        $event.target.parentNode.style.right = this.startCss+"px";
                    }
                }
            }
        },
        //Swap the letters between the "H" and the "F" 
        changeLetter:function(index,$ev){
            if($ev.target.value == 0){
                this.incomingData[index].letter = "H";
                this.incomingData[index].header_or_footer = 0;
            }
            if($ev.target.value == 1){
                this.incomingData[index].letter = "F";
                this.incomingData[index].header_or_footer = 1;
            }
        },
        //Prepared data
        toPathFiles:function(ind){
            //First time click
            if(this.incomingData.length > 0){
                this.currentIndex = ind;
                //First time click
                if(typeof(this.highlightedItem.current) === "undefined"){
                    this.highlightedItem.current = ind;
                    this.$refs.liItem[this.highlightedItem.current].style.backgroundColor = "#E896CC";
                }else{//Each other time
                    this.highlightedItem.old = this.highlightedItem.current;
                    this.$refs.liItem[this.highlightedItem.old].style.backgroundColor = "#E8C3DC";
                    this.highlightedItem.current = ind;
                    this.$refs.liItem[this.highlightedItem.current].style.backgroundColor = "#E896CC";
                }
                //Show YES/NO buttons
                this.showDialogBox = false;
            }
        },
        //Transfer the prepared data by Event Bus
        toFilePathsComponent:function(event){
            //Reset color
            this.$refs.liItem[this.highlightedItem.current].style.backgroundColor = "#E8C3DC";
            this.showDialogBox = true;
             //Delete current elementfrom from the array and then get it
            let transferObj = this.incomingData.splice(this.currentIndex,1);
                this.dataPreparedFiles.model_id = transferObj[0].scriptable_id; 
                this.dataPreparedFiles.model = transferObj[0].scriptable_type; 
                this.dataPreparedFiles.path = transferObj[0].path_js; 
                this.dataPreparedFiles.h_f = transferObj[0].header_or_footer; 
                this.dataPreparedFiles.letter = transferObj[0].letter;
            //Use Event Bus
            EventEmitter.$emit("dataToFiles",this.dataPreparedFiles);
            //Reset index
            this.currentIndex = 0;
        },
        toRefuseFilePathsComponent:function(event){
            this.showDialogBox = true;
        }
    },
    computed:{
        showHideDialogBox(){
            return {accept_replace__block : !this.showDialogBox};//False at once when loaded
        }
    },
    created(){
        //Prepare data
        this.prepareIncomingData();
        //Use Event Bus
        EventEmitter.$on("dataToDB",data => {
            if(this.getType(data) == "object"){
                //
                this.incomingData.unshift({  //Vue.set();//or this.$set(array,ind,value)
                    path_js : data.path,
                    scriptable_id : data.model_id,
                    scriptable_type : data.model,
                    header_or_footer : data.h_f,
                    letter: data.letter
                });
            }
        });
    },
    mounted() {
        //Get value from CSS when app was loaded first time, the biggest value is right:-125px;
        let cssPropRight = window.getComputedStyle(this.$refs.h_f[0],null).getPropertyValue("right");
        this.startCss = parseInt(cssPropRight); 
    }
}
</script>
<style lang="scss" scoped>
.paths-list{
    list-style-type:none;
    .paths-list__item{
        overflow:hidden;
        border:1px solid #000;
        margin-top:5px;
        padding-left:35px;
        width:100%;
        background-color:#E8C3DC;
        position:relative;
        /*transition: background-color 3s;*/
        .paths-list__arrow{
            padding:0px;
            position:absolute;
            left:0px;
            top:0px;
            z-index:1;
        }
        .paths-list__text{
            padding-right:25px;
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
                background-color:#FDA5DF;
            }
            &:hover{
                background-color:#FDA5DF;
            }
        }
    }
}
</style>