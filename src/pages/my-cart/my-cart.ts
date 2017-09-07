import {Component} from '@angular/core';
import {IonicPage, NavController, NavParams} from 'ionic-angular';
import {Cart} from "../../providers/cart";

/**
 * Generated class for the MyCartPage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */

@IonicPage()
@Component({
    selector: 'page-my-cart',
    templateUrl: 'my-cart.html',
})
export class MyCartPage {

    constructor(public navCtrl: NavController,
                public navParams: NavParams,
                public cart: Cart) {
    }

    ionViewDidLoad() {
        console.log('ionViewDidLoad MyCartPage');
    }

    removeItem(index) {
        this.cart.removeItem(index);
    }
}
