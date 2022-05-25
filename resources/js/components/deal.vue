<template>
	<section class="deal">
		<div class="marketPrice" :class="upOrDown">
			<span class="price">{{numberFormat(marketPrice)}}<span class="twd">TWD</span></span>
			<span class="priceSpread">{{numberFormat(priceSpread)}}</span>
			<span class="rate">{{numberFormat(rate)}}%</span>
		</div>

		<div class="trading">
			<table>
				<tr class="title">
					<th class="buy" colspan="2">買價</th>
				</tr>
				<tr v-for="(n,i) in buy" :key="n">
					<td>{{buy[i].qty}}</td>
					<td class="buy">{{buy[i].price}}</td>
				</tr>
			</table>
			<table>
				<tr class="title">
					<th class="sell" colspan="2">賣價</th>
				</tr>
				<tr v-for="(n,i) in sell" :key="n">
					<td class="sell">{{sell[i].price}}</td>
					<td>{{sell[i].qty}}</td>
				</tr>
			</table>
		</div>

		<div class="bargain">
			<input type="radio" id="bidButton" name="mytabs">
			<label for="bidButton" class="bid">我要買</label>
			<div class="inputPrice">
				$ <input type="number" placeholder="請輸入買價" v-model="bid"><button class="send" @click="pendingOrder(2)">送出</button>
			</div>

			<input type="radio" id="askButton" name="mytabs">
			<label for="askButton" class="ask">我要賣</label>
			<div class="inputPrice">
				$ <input type="number" placeholder="請輸入賣價" v-model="ask"><button class="send" @click="pendingOrder(1)">送出</button>
			</div>
		</div>
	</section>
</template>

<style>
	.deal {
		display: inline-block;
		float: left;
		width: 50%;
	}

	.deal .marketPrice {
		width: 100%;
		text-align: center;
	}

	.deal .marketPrice.up {
		color: #e03f19;
	}

	.deal .marketPrice.down {
		color: #19B369;
	}

	.deal .marketPrice .price {
		font-size: 44px;
		margin-right: 30px;
	}

	.deal .marketPrice .price .twd {
		font-size: 18px;
		margin-left: 5px;
	}

	.deal .marketPrice .priceSpread,
	.deal .marketPrice .rate {
		font-size: 36px;
		margin-right: 30px;
	}

	.deal .marketPrice.up .priceSpread:before,
	.deal .marketPrice.up .rate:before {
		content:url("/image/up.svg");
		margin-right: 6px;
	}

	.deal .marketPrice.down .priceSpread:before,
	.deal .marketPrice.down .rate:before {
		content:url("/image/down.svg");
		margin-right: 6px;
	}

	.deal .trading {
		margin-top: 60px;
		text-align: center;
	}

	.deal table {
		display: inline-table;
	}

	.deal table tr {

	}

	.deal table > tr.title > th.buy {
		text-align: right;
	}

	.deal table > tr.title > th.sell {
		text-align: left;
	}

	.deal table tr th, .deal table tr td {
		padding: 5px 15px;
	}

	.deal table .buy {
		color: #19b369;
	}

	.deal table .sell {
		color: #e03f19;
	}

	.deal .bargain {
		width: 100%;
		text-align: center;
		display: flex;
		flex-wrap: wrap;
	}

	.deal .bargain label {
		margin: 15px;
		padding: 15px;
		cursor: pointer;
		display: inline-block;
	}

	.deal .bargain label.bid {
		background: #19b369;
		color: #fff;
		margin: 15px 15px 15px auto;
		position: relative;
	}

	.deal .bargain label.ask {
		background: #e03f19;
		color: #fff;
		margin: 15px auto 15px 15px;
		position: relative;
	}

	.deal .bargain input[type="radio"] {
		display: none;
	}

	.deal .bargain input[type="radio"]:checked + label:after {
		content: "";
		position: absolute;
		bottom: -7px;
		left: calc(50% - 6px);
		border-top: 0;
		border-left: 0;
		transform: rotate(45deg) translateY(0px);
		width: 12px;
		height: 12px;
	}

	.deal .bargain input[type="radio"]:checked + label.bid:after {
		border: 2px solid #19b369;
		background: #19b369;
	}

	.deal .bargain input[type="radio"]:checked + label.ask:after {
		border: 2px solid #e03f19;
		background: #e03f19;
	}

	.deal .bargain .inputPrice {
		order: 2;
		width: 100%;
	}

	.deal .bargain input[type="radio"]:not(:checked) + label + .inputPrice {
		display: none;
	}

	.deal .bargain input {
		border: 1px solid #cfcfcf;
		font-size: 17px;
		padding: 15px;
		width: 50%;
	}

	.deal .bargain button.send {
		margin: 15px;
		padding: 15px;
		cursor: pointer;
		border: 1px solid grey;
		color: grey;
	}
</style>

<script>
	export default {
		props: ['product'],
		data: function () {
			return{
				marketPrice:0,
				priceSpread:0,
				rate:0,
				buy:[],
				sell:[],
				bid:'',
				ask:''
			}
		},
		methods: {
			getMarketPrice: function () {
				let self = this;
				axios.get('/product/marketPrice', { params:{ p_id: this.product }})
					.then(function (response) {
						let re = response.data;
						if(re.status == 'ok') {
							self.marketPrice = re.data.marketPrice;
							self.priceSpread = re.data.priceSpread;
							self.rate = re.data.rate;
						}
					})
					.catch(function (response) {
						console.log(response);
					});
			},
			getPendingOrder: function () {
				let self = this;
				axios.get('/product/pendingOrder', { params:{ p_id: this.product }})
					.then(function (response) {
						let re = response.data;
						if(re.status == 'ok') {
							self.buy = re.data.buy;
							self.sell = re.data.sell;
						}
					})
					.catch(function (response) {
						console.log(response);
					});
			},
			pendingOrder: function (type) {
				console.log(type)
				let self = this;
				var price;
				if(type==1){
					self.bid = '';
					price = self.ask;
				}else if(type==2){
					self.ask = '';
					price = self.bid;
				}
				axios.post('/product/pendingOrder', { p_id: this.product, type: type, price:price })
					.then(function (response) {
						console.log(response.data)
						let re = response.data;
						if(re.status == 'ok') {
							//self.getPendingOrder();
						}
					})
					.catch(function (response) {
						console.log(response);
					});
			},
			numberFormat: function (number) {
				return new Intl.NumberFormat('en-US', { maximumSignificantDigits: 3 }).format(number)
			}
		},
		mounted: function () {
			/*Pusher.logToConsole = true;
			Echo.channel('product.'+this.product)
				.listen('.pendingOrder', (e) => {
					console.log(e);
					this.buy = e.data.buy;
					this.sell = e.data.sell;

				}).listen('.clinch', (e) => {
				console.log(e);
				this.marketPrice = e.data.marketPrice;
				this.priceSpread = e.data.priceSpread;
				this.rate = e.data.rate;
			});*/
			this.getMarketPrice();
			this.getPendingOrder();
		},
		computed: {
			upOrDown: function () {
				return this.priceSpread >= 0 ? 'up' : 'down'
			}
		}
	}
</script>