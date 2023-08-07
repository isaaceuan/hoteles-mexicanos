<template>
	<div class="input-group input-spinner"
		 :class="{'input-group-sm': size == 'sm', 'input-group-lg': size == 'lg'}">
		<span class="input-group-prepend">
			<button
					@click='decreaseNumber'
					class="btn"
					:class='buttonClass' type="button">-</button>
		</span>
		<input class="form-control"
			   type='number'
               readonly
			   v-bind:value='numericValue'
			   @keypress='validateInput'
			   @input='inputValue'
			   :class='inputClass'
			   :min='min'
			   :max='max'>
		<span class="input-group-append">
			<button
					@click='increaseNumber'
					:class='buttonClass'
					class="btn" type="button">+</button>
		</span>
	</div>
</template>

<script>
	export default {
		name: 'InputSpinner',

		data: function() {
			return {
				numericValue: this.value,
				timer: null
			};
		},
		props: {
			value: {
				type: Number,
				default: 0
			},
			min: {
				default: 0,
				type: Number
			},
			max: {
				default: 10,
				type: Number
			},
			step: {
				default: 1,
				type: Number
			},
			size:{
				default: '',
				type: String
			},
			inputClass: {
				default: '',
				type: String
			},
			buttonClass: {
				default: 'btn-primary',
				type: String
			},
			integerOnly: {
				default: false,
				type: Boolean
			}
		},	methods: {
			clearTimer() {
				if (this.timer) {
					clearInterval(this.timer);
					this.timer = null;
				}
			},

			increaseNumber() {
				this.numericValue += this.step;
			},

			decreaseNumber() {
				this.numericValue -= this.step;
			},

			isInteger(evt) {
				evt = evt ? evt : window.event;
				let key = evt.keyCode || evt.which;
				key = String.fromCharCode(key);
				const regex = /[0-9]/;

				if (!regex.test(key)) {
					evt.returnValue = false;
					if (evt.preventDefault) evt.preventDefault();
				}
			},

			isNumber(evt) {
				evt = evt ? evt : window.event;
				var charCode = evt.which ? evt.which : evt.keyCode;

				if (
					charCode > 31 &&
					(charCode < 48 || charCode > 57) &&
					charCode !== 46
				) {
					evt.preventDefault();
				} else {
					return true;
				}
			},

			validateInput(evt) {
				if (this.integerOnly === true) {
					this.isInteger(evt);
				} else {
					this.isNumber(evt);
				}
			},

			inputValue(evt) {
				this.numericValue = evt.target.value
					? parseInt(evt.target.value)
					: this.min;
			},
			setVal(val){
				this.numericValue = val;
			}
		},

		watch: {
			numericValue: function(val, oldVal) {
				if (val <= this.min) {
					this.numericValue = parseInt(this.min);
				}

				if (val >= this.max) {
					this.numericValue = parseInt(this.max);
				}

				if (val <= this.max && val >= this.min) {
					this.$emit('input', val, oldVal);
				}
			},
			value: function (val) {
				this.numericValue = val;
			}
		}
	};
</script>

<style lang='scss'>
	/* Chrome, Safari, Edge, Opera */
	.input-spinner input::-webkit-outer-spin-button,
	.input-spinner input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}

	/* Firefox */
	.input-spinner input[type=number] {
		-moz-appearance: textfield;
	}
</style>
