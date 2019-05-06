<!DOCTYPE html>
<meta charset="utf-8">
<canvas width="960" height="960"></canvas>
<script src="https://d3js.org/d3.v4.min.js"></script>

<script>
width=960, height=960
// 生成节点
var nodes = d3.range(20).map(function(i) {
  return {
    index: i,
    color: d3.rgb(d3.randomUniform(0, 256)(),d3.randomUniform(0, 256)(),d3.randomUniform(0, 256)()),
  };
});
// 生成节点间连接
var links = d3.range(nodes.length - 1).map(function(i) {
  return {
    source: Math.floor(Math.sqrt(i)),
    target: i + 1,
  };
});

var simulation = d3.forceSimulation(nodes)
    .force("charge", d3.forceManyBody().strength(-300))
    .force("link", d3.forceLink(links).distance(linkdistance).strength(1))
    .force("collide",d3.forceCollide(40))
    .on("tick", ticked);

var canvas = document.querySelector("canvas"),
    context = canvas.getContext("2d"),
    width = canvas.width,
    height = canvas.height;

d3.select(canvas)
    .call(d3.drag()
        .container(canvas)
        .subject(dragsubject)
        .on("start", dragstarted)
        .on("drag", dragged)
        .on("end", dragended));


function ticked() {
  context.clearRect(0, 0, width, height);
  context.save();
  context.translate(width / 2, height / 2);

  context.beginPath();
  links.forEach(drawLink);
  context.strokeStyle = "#aaa";
  context.stroke();

  //context.beginPath();
  nodes.forEach(drawNode);
  //context.fillStyle = d3.rgb(d3.randomUniform(0, 256)(),d3.randomUniform(0, 256)(),d3.randomUniform(0, 256)());
  //context.fill();
  
  context.restore();
}

function linkdistance(d) {
	return 100;
}

function dragsubject() {
  return simulation.find(d3.event.x - width / 2, d3.event.y - height / 2);
}

function dragstarted() {
  if (!d3.event.active) simulation.alphaTarget(0.3).restart();
  d3.event.subject.fx = d3.event.subject.x;
  d3.event.subject.fy = d3.event.subject.y;
}

function dragged() {
  d3.event.subject.fx = d3.event.x;
  d3.event.subject.fy = d3.event.y;
}

function dragended() {
  if (!d3.event.active) simulation.alphaTarget(0);
  d3.event.subject.fx = null;
  d3.event.subject.fy = null;
}

function drawLink(d) {
  context.moveTo(d.source.x, d.source.y);
  context.lineTo(d.target.x, d.target.y);
}

function drawNode(d) {
  context.beginPath();
  context.moveTo(d.x + 3, d.y);
  context.arc(d.x, d.y, 40, 0, 2 * Math.PI);
  context.fillStyle = d.color;
  context.fill();
  context.closePath();
}

</script>