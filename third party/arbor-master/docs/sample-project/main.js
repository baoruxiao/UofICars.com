//
//  main.js
//
//  A project template for using arbor.js
//

(function($){

  var Renderer = function(canvas){
    var canvas = $(canvas).get(0)
    var ctx = canvas.getContext("2d");
    var particleSystem
    var gfx = arbor.Graphics(canvas)
    var that = {
      init:function(system){
        //
        // the particle system will call the init function once, right before the
        // first frame is to be drawn. it's a good place to set up the canvas and
        // to pass the canvas size to the particle system
        //
        // save a reference to the particle system for use in the .redraw() loop
        particleSystem = system

        // inform the system of the screen dimensions so it can map coords for us.
        // if the canvas is ever resized, screenSize should be called again with
        // the new dimensions
        particleSystem.screenSize(canvas.width, canvas.height) 
        particleSystem.screenPadding(80) // leave an extra 80px of whitespace per side
        
        // set up some event handlers to allow for node-dragging
        that.initMouseHandling()
      },
      
      redraw:function(){
        // 
        // redraw will be called repeatedly during the run whenever the node positions
        // change. the new positions for the nodes can be accessed by looking at the
        // .p attribute of a given node. however the p.x & p.y values are in the coordinates
        // of the particle system rather than the screen. you can either map them to
        // the screen yourself, or use the convenience iterators .eachNode (and .eachEdge)
        // which allow you to step through the actual node objects but also pass an
        // x,y point in the screen's coordinate system
        // 
        ctx.fillStyle = "white"
        ctx.fillRect(0,0, canvas.width, canvas.height)
        
        particleSystem.eachEdge(function(edge, pt1, pt2){
          // edge: {source:Node, target:Node, length:#, data:{}}
          // pt1:  {x:#, y:#}  source position in screen coords
          // pt2:  {x:#, y:#}  target position in screen coords

          // draw a line from pt1 to pt2
          ctx.strokeStyle = "rgba(0,0,0, .333)"
          ctx.lineWidth = 1
          ctx.beginPath()
          ctx.moveTo(pt1.x, pt1.y)
          ctx.lineTo(pt2.x, pt2.y)
          ctx.stroke()
        })

        particleSystem.eachNode(function(node, pt){
        if (!node.label){
          var w = Math.max(20, 20+gfx.textWidth(node.name) )        
        } else {
          var w = Math.max(20, 20+gfx.textWidth(node.label) )         
        }

          if (node.data.alpha===0) return
          if (node.data.shape=='dot'){
            gfx.oval(pt.x-w/2, pt.y-w/2, w, w, {fill:node.data.color, alpha:node.data.alpha})
            if(node.data.label){
	        gfx.text(node.data.label, pt.x, pt.y+7, {color:"white", align:"center", font:"Arial", size:12})
            	gfx.text(node.data.label, pt.x, pt.y+7, {color:"white", align:"center", font:"Arial", size:12})            
            } else {
	        gfx.text(node.name, pt.x, pt.y+7, {color:"white", align:"center", font:"Arial", size:12})
            	gfx.text(node.name, pt.x, pt.y+7, {color:"white", align:"center", font:"Arial", size:12})               
            }
            

          }else{
            gfx.rect(pt.x-w/2, pt.y-8, w, 20, 4, {fill:node.data.color, alpha:node.data.alpha})
            if(node.data.label){
		gfx.text(node.data.label, pt.x, pt.y+9, {color:"white", align:"center", font:"Arial", size:12})
            	gfx.text(node.data.label, pt.x, pt.y+9, {color:"white", align:"center", font:"Arial", size:12})            
            }else{
		gfx.text(node.name, pt.x, pt.y+9, {color:"white", align:"center", font:"Arial", size:12})
            	gfx.text(node.name, pt.x, pt.y+9, {color:"white", align:"center", font:"Arial", size:12})            
            }

          }
        })    			
      },
      
      initMouseHandling:function(){
        // no-nonsense drag and drop (thanks springy.js)
        var dragged = null;

        // set up a handler object that will initially listen for mousedowns then
        // for moves and mouseups while dragging
        var handler = {
          clicked:function(e){
            var pos = $(canvas).offset();
            _mouseP = arbor.Point(e.pageX-pos.left, e.pageY-pos.top)
            dragged = particleSystem.nearest(_mouseP);

            if (dragged && dragged.node !== null){
              // while we're dragging, don't let physics move the node
              dragged.node.fixed = true
            }

            $(canvas).bind('mousemove', handler.dragged)
            $(window).bind('mouseup', handler.dropped)

            return false
          },
          dragged:function(e){
            var pos = $(canvas).offset();
            var s = arbor.Point(e.pageX-pos.left, e.pageY-pos.top)

            if (dragged && dragged.node !== null){
              var p = particleSystem.fromScreen(s)
              dragged.node.p = p
            }

            return false
          },

          dropped:function(e){
            if (dragged===null || dragged.node===undefined) return
            if (dragged.node !== null) dragged.node.fixed = false
            dragged.node.tempMass = 1000
            dragged = null
            $(canvas).unbind('mousemove', handler.dragged)
            $(window).unbind('mouseup', handler.dropped)
            _mouseP = null
            return false
          }
        }
        
        // start listening
        $(canvas).mousedown(handler.clicked);

      },
      
    }
    return that
  }

  $(document).ready(function(){
    var sys = arbor.ParticleSystem(1000, 600, 0.5) // create the system with sensible repulsion/stiffness/friction
    sys.parameters({gravity:true}) // use center-gravity to make the graph settle nicely (ymmv)
    sys.renderer = Renderer("#viewport") // our newly created renderer will have its .init() method called shortly by sys...

    // add some nodes to the graph and watch it go...
    // sys.addNode('a', {label:"aaa"})
    // sys.addEdge('a','b')
    // sys.addEdge('a','c')
    // sys.addEdge('a','d')
    // sys.addEdge('a','e')
    // sys.addEdge('b','e')
    // sys.addNode('f', {label:"aaa",alone:true, mass:.25})

    // or, equivalently:
    //

    var CLR = {
      branch:"#b2b19d",
      attributes:"#5DBCD2",
      attributes_2:"#DFE08F",
      car_attributes: "#E0BA8F",
      cars: "#256C9C",
      code:"orange",
      doc:"#922E00",
      demo:"#a7af00"
    }

//       obj = 
// {
// "netid":"rxbao",
// "similar":[
// {
// "netid":"xmeng13",
// "distance":1245,
// "topclick":{
// "carid":[
// 123,
// 234,
// 456
// ],
// "clicktime":[
// 6,
// 4,
// 3
// ]
// }
// },
// {
// "netid":"xmeng14",
// "distance":3245,
// "topclick":{
// "carid":[
// 1223,
// 2794,
// 4756
// ],
// "clicktime":[
// 5,
// 2,
// 1
// ]
// }
// },
// {
// "netid":"xmeng15",
// "distance":5000,
// "topclick":{
// "carid":[
// 215,
// 2234,
// 4516
// ],
// "clicktime":[
// 3,
// 2,
// 1
// ]
// }
// },
// {
// "netid":"xmeng16",
// "distance":6542,
// "topclick":{
// "carid":[
// 1293,
// 2324,
// 4256
// ],
// "clicktime":[
// 15,
// 3,
// 1
// ]
// }
// }
// ]
// };

obj1 = 
{
"netid":"rxbao",
"nationality":"North",
"sex":"male",
"price_range":{
"lprice":"12345",
"hprice":"34567"
},
"degree":"bachelor",
"similar":[
{
"netid":"lshe16",
"distance":4044,
"degree":"bachelor",
"nationality":"North",
"sex":"male",
"price_range":{
"lprice":"25000",
"hprice":"30000"
},
"topclick":[
{
"carid":"101",
"make":"BMW",
"model":"318",
"bodystyleName":"Sedan",
"year":"1997",
"price":"2850",
"miles":"160503",
"count":4
}
]
},
{
"netid":"xmeng16",
"distance":5956,
"degree":"bachelor",
"nationality":"North",
"sex":"male",
"price_range":{
"lprice":"15000",
"hprice":"20000"
},
"topclick":[
{
"carid":"129",
"make":"BMW",
"model":"318",
"bodystyleName":"Sedan",
"year":"1997",
"price":"2850",
"miles":"160503",
"count":4
},
{
"carid":"130",
"make":"BMW",
"model":"325",
"bodystyleName":"Convertible",
"year":"2006",
"price":"12390",
"miles":"66723",
"count":4
},
{
"carid":"131",
"make":"BMW",
"model":"318",
"bodystyleName":"Hatchback",
"year":"1997",
"price":"0",
"miles":"149777",
"count":4
},
{
"carid":"128",
"make":"BMW",
"model":"318",
"bodystyleName":"Coupe",
"year":"1995",
"price":"2295",
"miles":"122264",
"count":3
},
{
"carid":"5261",
"make":"Jaguar",
"model":"XF",
"bodystyleName":"Sedan",
"year":"2012",
"price":"33995",
"miles":"24479",
"count":2
}
]
}
]
}
obj = obj1;

$.getJSON( "http://uoficarstore.web.engr.illinois.edu/RS.php", function( data ) {
	obj = data;
// add central node
sys.addNode(obj.netid, {color:"red", shape:"dot", alpha:1});

// add CN attributes node
//sys.addNode("nationality: "+obj.nationality + obj.netid, {label: "nationality: " + obj.nationality,color:CLR.attributes, alpha:1});
//sys.addNode("gender: "+obj.sex + obj.netid, {label: "gender: "+obj.sex, color:CLR.attributes, alpha:1});
//sys.addNode("lprice: "+obj.price_range.lprice + obj.netid, {label: "lprice: "+obj.price_range.lprice, color:CLR.attributes, alpha:1});
//sys.addNode("hprice: "+obj.price_range.hprice + obj.netid, {label: "hprice: "+obj.price_range.hprice, color:CLR.attributes, alpha:1});

// add CN attributes edge
//sys.addEdge(obj.netid,"nationality: " + obj.nationality + obj.netid);
//sys.addEdge(obj.netid,"gender: "+obj.sex + obj.netid);
//sys.addEdge(obj.netid,"lprice: "+obj.price_range.lprice + obj.netid);
//sys.addEdge(obj.netid,"hprice: "+obj.price_range.hprice + obj.netid);

// add 1st branch node
flg = 0
for(var r in obj.similar){
  flg = flg + 1;
  sys.addNode(obj.similar[r].netid, {color:CLR.branch, shape:"dot", alpha:1});
  sys.addNode("nationality: "+obj.similar[r].nationality + obj.similar[r].netid, {label: "nationality: "+obj.similar[r].nationality, color:CLR.attributes_2, alpha:1});
  sys.addNode("gender: "+obj.similar[r].sex + obj.similar[r].netid, {label: "gender: "+obj.similar[r].sex, color:CLR.attributes_2, alpha:1});
  sys.addNode("lprice: "+obj.similar[r].price_range.lprice + obj.similar[r].netid, {label: "lprice: "+obj.similar[r].price_range.lprice, color:CLR.attributes_2, alpha:1});
  sys.addNode("hprice: "+obj.similar[r].price_range.hprice + obj.similar[r].netid, {label: "hprice: "+obj.similar[r].price_range.hprice, color:CLR.attributes_2, alpha:1});
  for(var q in obj.similar[r].topclick){
    sys.addNode(obj.similar[r].topclick[q].carid, {label: obj.similar[r].topclick[q].make, color:CLR.cars, shape:"dot", alpha:1});
    //sys.addNode("make: "+obj.similar[r].topclick[q].make + obj.similar[r].topclick[q].carid, {label: "make: " + obj.similar[r].topclick[q].make, color:CLR.car_attributes, alpha:1});
    sys.addNode("model: "+obj.similar[r].topclick[q].model + obj.similar[r].topclick[q].carid, {label: "model: " + obj.similar[r].topclick[q].model, color:CLR.car_attributes, alpha:1});
    //sys.addNode("bodystle: "+obj.similar[r].topclick[q].bodystyleName + obj.similar[r].topclick[q].carid, {label: "bodystle: " + obj.similar[r].topclick[q].bodystyleName, color:CLR.car_attributes, alpha:1});
    sys.addNode("year: "+obj.similar[r].topclick[q].year + obj.similar[r].topclick[q].carid, {label: "year: " + obj.similar[r].topclick[q].year, color:CLR.car_attributes, alpha:1});
    sys.addNode("price: "+obj.similar[r].topclick[q].price + obj.similar[r].topclick[q].carid, {label: "price: " + obj.similar[r].topclick[q].price, color:CLR.car_attributes, alpha:1});
    //sys.addNode("mileages: "+obj.similar[r].topclick[q].miles + obj.similar[r].topclick[q].carid, {label: "mileages: " + obj.similar[r].topclick[q].miles, color:CLR.car_attributes, alpha:1});   
  }
}
// add 1st branch edge
for(var r in obj.similar){
  sys.addEdge(obj.netid,obj.similar[r].netid, obj.similar[r].distance);
  sys.addEdge(obj.similar[r].netid,"nationality: " + obj.similar[r].nationality + obj.similar[r].netid);
  sys.addEdge(obj.similar[r].netid,"gender: "+obj.similar[r].sex + obj.similar[r].netid);
  sys.addEdge(obj.similar[r].netid,"lprice: "+obj.similar[r].price_range.lprice + obj.similar[r].netid);
  sys.addEdge(obj.similar[r].netid,"hprice: "+obj.similar[r].price_range.hprice + obj.similar[r].netid);
  for(var q in obj.similar[r].topclick){
    sys.addEdge(obj.similar[r].netid, obj.similar[r].topclick[q].carid, obj.similar[r].topclick[q].count);
    //sys.addEdge(obj.similar[r].topclick[q].carid,"make: " + obj.similar[r].topclick[q].make + obj.similar[r].topclick[q].carid);
    sys.addEdge(obj.similar[r].topclick[q].carid,"model: " + obj.similar[r].topclick[q].model + obj.similar[r].topclick[q].carid);
    //sys.addEdge(obj.similar[r].topclick[q].carid,"bodystle: " + obj.similar[r].topclick[q].bodystyleName + obj.similar[r].topclick[q].carid);
    sys.addEdge(obj.similar[r].topclick[q].carid,"year: " + obj.similar[r].topclick[q].year + obj.similar[r].topclick[q].carid);
    sys.addEdge(obj.similar[r].topclick[q].carid,"price: " + obj.similar[r].topclick[q].price + obj.similar[r].topclick[q].carid);
    //sys.addEdge(obj.similar[r].topclick[q].carid,"mileages: " + obj.similar[r].topclick[q].miles + obj.similar[r].topclick[q].carid);    
  }
}


});




  })


})(this.jQuery)