<?
  include "./admin_header.php";
?>


    <div class="pagetitle">
      <h1>Dashboard</h1>
      <!-- <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav> -->
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <div class="col-12 d-flex">
              <div class="card col-2" style="margin-right:3%">
                <div class="">
                <select class="form-select brand">
                  <option value="브랜드1">브랜드1</option>
                  <option value="브랜드2">브랜드2</option>
                  <option value="브랜드3">브랜드3</option>
                  <option value="브랜드4">브랜드4</option>
                </select>
                </div>
              </div>
              <div class="card col-3">
                <div class="">
                <select class="form-select brand">
                  <option value="상품1">상품1</option>
                  <option value="상품2">상품2</option>
                  <option value="상품3">상품3</option>
                </select>
                </div>
              </div>

            </div>

          <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">총 판매수 <span>| 20.06.01 ~</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6>13</h6>
                      <span class="text-muted small pt-2 ps-1">전일 대비</span> <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">상승</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="filter">
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                </div>

                <div class="card-body">
                  <h5 class="card-title">총 판매 금액 <span>| 20.06.01 ~</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6>￦494,000,000</h6>
                      <span class="text-muted small pt-2 ps-1">전일 대비</span> <span class="text-success small pt-1 fw-bold">18%</span> <span class="text-muted small pt-2 ps-1">상승</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <!-- <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div> -->

                <div class="card-body">
                  <h5 class="card-title">미답변 문의 <span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>3</h6>
                      <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            <div class="col-6">
              <div class="card">
                <h5 class="card-title">판매수 (~7일)</h5>
                
                <div id="sales-count" style="min-height: 400px;" class="echart"></div>
                <script>

                  document.addEventListener("DOMContentLoaded", () => {
                    var chartDom = document.getElementById('sales-count');
                    var myChart = echarts.init(chartDom);
                    var option;

                    option = {
                      xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: ['06.22', '06.21', '06.20', '06.19', '06.18', '06.17', '06.16'],
                      },
                      yAxis: {
                        type: 'value'
                      },
                      tooltip: {
                        trigger: 'axis'
                      },                      
                      series: [
                        {
                          data: [1, 3, 2, 8, 5, 6, 1],
                          type: 'line',
                          itemStyle: {
                            color: '#efd103'
                          },
                          areaStyle: {
                            color: 'rgb(242, 238, 204)'
                          }
                        }
                      ]
                    };
                    option && myChart.setOption(option);
                  });
                </script>
              </div>
            </div>

            <div class="col-6">
              <div class="card">
                <h5 class="card-title">판매 금액 (~7일)</h5>
                <div id="sales-amount" style="min-height: 400px;" class="echart"></div>
                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    var chartDom = document.getElementById('sales-amount');
                    var myChart = echarts.init(chartDom);
                    var option;

                    option = {
                      xAxis: {
                        type: 'category',
                        data: ['06.22', '06.21', '06.20', '06.19', '06.18', '06.17', '06.16']
                      },
                      yAxis: {
                        type: 'value'
                      },
                      tooltip: {
                        trigger: 'axis'
                      },
                      series: [
                        {
                          data: [3500, 7500, 4800, 10500, 9900, 5200, 3500],
                          type: 'line',
                          // smooth: true
                        }
                      ]
                    };

                    option && myChart.setOption(option);
                  });
                </script>
              </div>
            </div>
          
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex" style="align-items:center;justify-content:space-between;"><h5 class="card-title">문의</h5><p style="padding:20px 0 15px 0">더보기 +</p></div>

                  <!-- Default Table -->
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">이름</th>
                        <th scope="col">제목</th>
                        <th scope="col">등록일</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>장현준</td>
                        <td>근데 왜 이리 비싸요?</td>
                        <td>2023-06-17</td>
                        <td><span class="badge bg-danger">미답변</span></td>
                      </tr>
                      <tr>
                        <th scope="row">2</th>
                        <td>장현준</td>
                        <td>라면도 끓여지나요?</td>
                        <td>2023-06-17</td>
                        <td><span class="badge bg-danger">미답변</span></td>
                      </tr>
                      <tr>
                        <th scope="row">3</th>
                        <td>장현준</td>
                        <td>물 끓여지나요?</td>
                        <td>2023-06-15</td>
                        <td><span class="badge bg-danger">미답변</span></td>
                      </tr>
                      <tr>
                        <th scope="row">4</th>
                        <td>오예스</td>
                        <td>문의 드립니다.</td>
                        <td>2023-06-11</td>
                        <td><span class="badge bg-success">완료</span></td>
                      </tr>
                      <tr>
                        <th scope="row">5</th>
                        <td>빈츠</td>
                        <td>빅파이는 큰 편인거죠?</td>
                        <td>2023-06-10</td>
                        <td><span class="badge bg-danger">미답변</span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            
            
            <style>
              .mvalue{padding:1rem;justify-content:flex-start;border-bottom:1px solid #444;font-size:1.2rem;width:100%;margin-bottom:50px;}
              .mvalue div{width:80%;text-align:left;}
              .total{}
              .spend{}
              .balace{}
            </style>
            
            <div class="col-12 card flex-column" style="padding:0.5rem">
              <div class="col-lg-12">
                  <div class="car-body">
                      <div class="cont d-flex justify-content-start align-items-end mvalue">
                        <div class="total">총액 : 5,000,000</div>
                        <div class="spend">지출액 : 2,950,000</div>
                        <div class="balance">잔액 : 2,050,000</div>
                      </div>
                  </div>
                </div>

              <div class="col-lg-12">
                <div class="card-body">
                    <div id="sales-marketing" style="min-height: 400px;" class="echart"></div>
                    <script>
                      document.addEventListener("DOMContentLoaded", () => {
                        var chartDom = document.getElementById('sales-marketing');
                        var myChart = echarts.init(chartDom);
                        var option;

                        option = {
                          title: {
                            text: '마케팅 비용 현황',
                            subtext: '매체 별 금액(단위 : 만원)',
                            left: 'center'
                          },
                          tooltip: {
                            trigger: 'item',
                            formatter: '{b} <br/>{c}만원'
                          },
                          legend: {
                            orient: 'vertical',
                            left: 'left'
                          },
                          series: [
                            {
                              name: 'Access From',
                              type: 'pie',
                              radius: '50%',
                              data: [
                                { value: 60, name: '페이스북' },
                                { value: 30, name: '구글 키워드' },
                                { value: 55, name: '찌라시' },
                                { value: 150, name: '행사' }
                              ],
                              emphasis: {
                                itemStyle: {
                                  shadowBlur: 10,
                                  shadowOffsetX: 0,
                                  shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                              }
                            }
                          ]
                        };

                        option && myChart.setOption(option);
                      });
                    </script>
                </div>
              </div>
            </div>
            
            
            <!-- Reports -->
            <!-- <div class="col-12">
              <div class="card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Reports <span>/Today</span></h5>

                  <div id="reportsChart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Sales',
                          data: [31, 40, 28, 51, 42, 82, 56],
                        }, {
                          name: 'Revenue',
                          data: [11, 32, 45, 32, 34, 52, 41]
                        }, {
                          name: 'Customers',
                          data: [15, 11, 32, 18, 9, 24, 11]
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'datetime',
                          categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy HH:mm'
                          },
                        }
                      }).render();
                    });
                  </script>

                </div>

              </div>
            </div> -->
            <!-- End Reports -->

            <!-- Top Selling -->
            <!-- <div class="col-12">
              <div class="card top-selling overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body pb-0">
                  <h5 class="card-title">Top Selling <span>| Today</span></h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Preview</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Sold</th>
                        <th scope="col">Revenue</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row"><a href="#"><img src="tpl/assets/img/product-1.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Ut inventore ipsa voluptas nulla</a></td>
                        <td>$64</td>
                        <td class="fw-bold">124</td>
                        <td>$5,828</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="tpl/assets/img/product-2.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Exercitationem similique doloremque</a></td>
                        <td>$46</td>
                        <td class="fw-bold">98</td>
                        <td>$4,508</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="tpl/assets/img/product-3.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Doloribus nisi exercitationem</a></td>
                        <td>$59</td>
                        <td class="fw-bold">74</td>
                        <td>$4,366</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="tpl/assets/img/product-4.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Officiis quaerat sint rerum error</a></td>
                        <td>$32</td>
                        <td class="fw-bold">63</td>
                        <td>$2,016</td>
                      </tr>
                      <tr>
                        <th scope="row"><a href="#"><img src="tpl/assets/img/product-5.jpg" alt=""></a></th>
                        <td><a href="#" class="text-primary fw-bold">Sit unde debitis delectus repellendus</a></td>
                        <td>$79</td>
                        <td class="fw-bold">41</td>
                        <td>$3,239</td>
                      </tr>
                    </tbody>
                  </table>

                </div>

              </div>
            </div>End Top Selling -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

        
         <!-- Website Traffic -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body pb-0">
              <h5 class="card-title">유입 현황</h5>

              <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  echarts.init(document.querySelector("#trafficChart")).setOption({
                    tooltip: {
                      trigger: 'item'
                    },
                    legend: {
                      top: '5%',
                      left: 'center'
                    },
                    series: [{
                      name: '매체',
                      type: 'pie',
                      radius: ['40%', '70%'],
                      avoidLabelOverlap: false,
                      label: {
                        show: false,
                        position: 'center'
                      },
                      emphasis: {
                        label: {
                          show: true,
                          fontSize: '18',
                          fontWeight: 'bold'
                        }
                      },
                      labelLine: {
                        show: false
                      },
                      data: [{
                          value: 1048,
                          name: '포털 검색'
                        },
                        {
                          value: 35,
                          name: '직접 접속'
                        },
                        {
                          value: 580,
                          name: '유튜브'
                        },
                        {
                          value: 484,
                          name: '구글 Ads'
                        },
                        {
                          value: 300,
                          name: '페이스북 Ads'
                        }
                      ]
                    }]
                  });
                });
              </script>

            </div>
          </div>

         
        
        
          <!-- Recent Activity -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">판매 국가 순위</h5>

              <div id="country" style="min-height: 400px;" class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  var chartDom = document.getElementById('country');
                  var myChart = echarts.init(chartDom);
                  var option;

                  option = {
                    series: [
                      {
                        type: 'treemap',
                        levels: [
                          {
                          },
                          {
                            colorSaturation: [0.7, 0.2],
                          },
                        ],
                        breadcrumb: {
                          show:false
                        },
                        data: [
                          {
                            name: '국가 순위',
                            value: 100,
                            children:[
                              {
                                name: '미국',
                                value: 14500,
                              },
                              {
                                name: '중국',
                                value: 13210,
                              },
                              {
                                name: '러시아',
                                value: 12989,
                              },
                              {
                                name: '남극',
                                value: 3100,
                              },
                              {
                                name: '북극',
                                value: 1550,
                              }
                            ]
                          }
                        ]
                      }
                    ]
                  };

                  option && myChart.setOption(option);
                });
              </script>


   
            </div>
          </div><!-- End Recent Activity -->

          <!-- Budget Report -->
          <div class="card">
            <div class="card-body pb-0">
              <h5 class="card-title">구매 성별</h5>

              <div id="femaleman" style="min-height: 400px;" class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  var chartDom = document.getElementById('femaleman');
                  var myChart = echarts.init(chartDom);
                  var option;

                  option = {
                    tooltip: {
                      trigger: 'axis',
                      axisPointer: {
                        type: 'shadow'
                      }
                    },
                    grid: {
                      left: '3%',
                      right: '4%',
                      bottom: '3%',
                      containLabel: true
                    },
                    xAxis: [
                      {
                        type: 'category',
                        data: ['불명', '남자', '여자'],
                        axisTick: {
                          alignWithLabel: true
                        }
                      }
                    ],
                    yAxis: [
                      {
                        type: 'value'
                      }
                    ],
                    series: [
                      {
                        name: '구매수',
                        type: 'bar',
                        barWidth: '30%',
                        data: [
                          {
                            value: 927,
                            itemStyle:{
                              color: '#6b6b6b'
                            }
                          },
                          {
                            value: 152,
                            itemStyle:{
                              color: '#f481dc'
                            }
                          },
                          {
                            value: 128,
                            itemStyle:{
                              color: '#f2dd4e',
                              borderColor: 'yellow'
                            }
                          },
                        ]
                      }
                    ]
                  };

                  option && myChart.setOption(option);
                });
              </script>

            </div>
          </div><!-- End Budget Report -->

 
        </div><!-- End Right side columns -->

      </div>
    </section>



<? include "admin_footer.php"; ?>