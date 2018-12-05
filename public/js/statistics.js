$(document).ready(function(){
	(function(){
		$.ajax({
			url: 'statistics/userSource',
			type: 'get',
			success: function(res) {
				$('#container').highcharts({
					chart: {
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false,
						className: 'd-block',
					},
					title: {
						text: '用户来源占比'
					},
					tooltip: {
						headerFormat: '{series.name}<br>',
						pointFormat: '{point.name}: <b>{point.percentage:.1f}%</b>'
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								// 通过 format 或 formatter 来格式化数据标签显示
								//format: '值: {point.y} 占比 {point.percentage} %',
								formatter: function() {
									//this 为当前的点（扇区）对象，可以通过  console.log(this) 来查看详细信息
									return '<span style="color: ' + this.point.color + '"> 值：' + this.y + '，占比' + this.percentage + '%</span>';
								}
							},
							showInLegend: true  // 显示在图例中
						}
					},
					series: [{
						type: 'pie',
						name: '用户来源占比',
						data: res.data,
					}]
				});
			}
		})
	})();
	
});