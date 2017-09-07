import {Component, ViewChild} from '@angular/core';

import {ContactPage} from '../contact/contact';
import {HomePage} from '../home/home';
import {ProductsListPage} from "../products-list/products-list";
import {NavParams, Tabs} from "ionic-angular";

@Component({
    templateUrl: 'tabs.html'
})
export class TabsPage {

    @ViewChild(Tabs)
    tabsRef: Tabs;

    tab1Root = HomePage;
    tab2Root = ProductsListPage;
    tab3Root = ContactPage;

    constructor(public navParams: NavParams) {

    }

    ionViewDidLoad() {
        let index = this.navParams.get('index');
        if (index !== null) {
            setTimeout(() => {
                this.tabsRef.select(index);
            },300);
        }
    }
}
