import SimpleBar from 'simplebar';
import 'simplebar/dist/simplebar.css';
const $ = require('jquery/dist/jquery.min');

$(document).ready(function(){
    //Main parent element of the Menu Left
    const menuLeft = $('.main-left-navbar');
    //ScrollBar instanced
    const Scroller = new SimpleBar($('.main-left-navbar__sidebar ul')[0],{
        autoHide: false
    });
    //Get position:fixed - 'left' value
    let leftValue = window.getComputedStyle(menuLeft[0], //'menuLeft[0]' - jQuery to JS
        null).getPropertyValue("width");
    //Click on input checkbox that referenced to label
    $('#check').click(function(){
        //if($(this).prop('checked')){//true - show Menu Left
        if($(this).is(":checked")){//true - hide Menu Left
            //From -250px to 0px
            $(menuLeft).animate({left:"0px"},500);
        }else{
            //From 0px to -250px
            $(menuLeft).animate({left:`-${leftValue}`},500);
        }
    });
    /*Mark as active an item of the Left Menu*/
    const topPresent = menuLeft[0].querySelectorAll(".main-left-navbar__top-level-present");
    const topAbsent = menuLeft[0].querySelectorAll(".main-left-navbar__top-level-absent");
    //Combine two arrays
        let arr1 = Array.prototype.slice.call(topPresent);
        let arr2 = Array.prototype.slice.call(topAbsent);
    const allTopLevelItems = arr1.concat(arr2);
    //Keep index of parent elements. The place for start to search to remove active item
    //Subscribe on 'click' event
    for(let i = 0;i < allTopLevelItems.length;i++){
        allTopLevelItems[i].addEventListener("click",function(event){
            activeItem.call(this,event,i);
        },false);
    }
    //Make it active. It calls by click
    function activeItem(e,ind){
        //CSS class for active top menu element - LI
        let currentEl =  e.target;
        //The 'A' element has been found
        if( (currentEl.nodeType  === 1) && (currentEl.tagName === "A") ){
            //
            if(sessionStorage.getItem("leftMenu")){
                let leftMenu = JSON.parse(sessionStorage.getItem("leftMenu"));
            }
            //Rewrite index globally
            sessionStorage.setItem("leftMenu",JSON.stringify({
                "menuLeftParent" : ind,
                "level" : +currentEl.parentElement.dataset.level,
                "order" : +currentEl.parentElement.dataset.order,
            }))
        }
    }
    //immediately invoked function expression, check sessionStorage
    //It calls each time when page is loading
    (function deactivateItem(){
        //Reset marked menu items if click occurs elsewhere behind the Left Menu
        const categoryURL = window.location.href.split('/',4)[3];
        let topParent;
        if(categoryURL === "category"){
            topParent = JSON.parse(sessionStorage.getItem("leftMenu"));
        }else{
            if(sessionStorage.getItem("leftMenu")){
                sessionStorage.removeItem("leftMenu");
            }
            topParent = null;
        }
        //Highlight marked menu item
        if(topParent !== null) {//If not null
            //Combined arrays and [existing index] - get parent with active class
            let index = +topParent.menuLeftParent || 0;
            let level = +topParent.level || null;
            let order = +topParent.order || null;
            //Get the TOP parent element LI
            let parentLiClicked = allTopLevelItems[index];
            //
            if (level !== null && order !== null){
                //Find UL with class related to Top level LI
                let ULs = parentLiClicked.getElementsByTagName("UL");
                //Top level LI elements
                if (level === 1) {
                    let span = parentLiClicked.firstChild.lastChild;
                    let activeClass = getActiveOrder(order);
                    span.classList.add(activeClass);
                    if(ULs[0]){
                        //Expands for top level
                        slideDown(parentLiClicked,ULs[0]);
                    }
                } else {//All sub levels
                    //Expands if has sub levels
                    slideDown(parentLiClicked,ULs[0]);
                    //Level 2 == UL index 0,
                    let ulIndex = level - 2;
                    //Find UL where link was clicked
                    let ulWhereClicked = ULs[ulIndex];
                    //console.log("UL ",ULs[(level-1)]);
                    let LIs = ulWhereClicked.getElementsByTagName("LI");
                    //
                    for (let i = 0; i < LIs.length; i++) {
                        let span = LIs[i].firstChild.lastChild;
                        //Find link and add the CSS class
                        if (+span.dataset.level === level && +span.dataset.order === order) {
                            let activeClass = getActiveOrder(order);
                            span.classList.add(activeClass);
                        }
                    }
                }
            }
        }
    })();
    //Get correct item from an 'order' sessionStorage property. Return class with correct active number
    function getActiveOrder(currentOrder){
        const orderLimit = 5;//Amount of all items on the image sprite
        let preparedClass;
        if(currentOrder <= orderLimit){
            preparedClass = "main-left-navbar__active-"+currentOrder;
        }else{
            let rest = parseInt(currentOrder) % orderLimit === 0 ? 5 : parseInt(currentOrder) % orderLimit;
            preparedClass = "main-left-navbar__active-"+rest;
        }
        return preparedClass;
    }
    //Expand Menu items, motion - false = animate height, true = fixed height
    function slideDown(topParentLI,parentUL){
        //Get DIV before UL
        let div = parentUL.parentNode.firstChild;
        //Get height of DIV before
        let divClickedHeight = window.getComputedStyle(div,null)
            .getPropertyValue("height");
        //Get height of UL with nested items
        let ulClickedHeight = window.getComputedStyle(parentUL,null)
            .getPropertyValue("height");
        //
        let height = parseInt(ulClickedHeight) + parseInt(divClickedHeight);
        //Expand nested menu items
        $(topParentLI).animate({height: height+'px'});
    }
    /*
    Top and Left Menus slide up and down together
    */
    //Get Top Menu sandwich button
    const sandwichBtn = document.getElementById("horizontal-menu-btn");
        sandwichBtn.addEventListener('click',moveBothConditionally,false);
    //Slide both Menus Up and Down using flag
    let upOrDown = false;
    //Get top navbar menu height 60px;
    const topNavbarHeight = window.getComputedStyle(sandwichBtn.parentNode,null)
        .getPropertyValue("height");
    //Call this function by click each time
    function moveBothConditionally(){
        let btn = this;
        if(!upOrDown){
            bothDown(btn);
        }else{
             bothUp(btn);
        }
    }
    //Go down
    function bothDown(btn){
        //Change flag to true
        upOrDown = true;
        //Set 'auto' to resize height
        btn.parentNode.style.height = "auto";
        //Get left menu
        const leftMenu = document.querySelector(".main-left-navbar");
        setTimeout(()=>{
            //Inner Navbar content
            //const contentMenu = document.getElementById("navbarSupportedContent");
            const topMenu = document.querySelector(".main-top-navbar");
            //Inner Navbar content height
            let contentMenuHeight = window.getComputedStyle(topMenu,null)
                .getPropertyValue("height");
            //let fullHeight = parseInt(contentMenuHeight) + parseInt(topNavbarHeight) - 5;
            $(leftMenu).animate({top: contentMenuHeight});
        },700);
    }
    //Go up
    function bothUp(btn){
        //Change flag to default
        upOrDown = false;
        //
        const leftMenu = document.querySelector(".main-left-navbar");
        //Left menu lift up
        $(leftMenu).animate({top: parseInt(topNavbarHeight)});
        $(btn.parentNode).animate({height: parseInt(topNavbarHeight)});
    }
});
