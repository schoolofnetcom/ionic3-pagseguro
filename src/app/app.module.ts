import {NgModule, ErrorHandler} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';
import {IonicApp, IonicModule, IonicErrorHandler} from 'ionic-angular';
import {MyApp} from './app.component';

import {AboutPage} from '../pages/about/about';
import {ContactPage} from '../pages/contact/contact';
import {HomePage} from '../pages/home/home';
import {TabsPage} from '../pages/tabs/tabs';

import {StatusBar} from '@ionic-native/status-bar';
import {SplashScreen} from '@ionic-native/splash-screen';
import {ProductsListPage} from "../pages/products-list/products-list";
import {ProductHttp} from '../providers/product-http';
import {HttpModule} from "@angular/http";
import {ProductDetailPage} from "../pages/product-detail/product-detail";
import {Cart} from '../providers/cart';
import {MyCartPage} from "../pages/my-cart/my-cart";
import {ButtonCartComponent} from "../components/button-cart/button-cart";
import {CheckoutPage} from "../pages/checkout/checkout";
import {PaymentHttp} from '../providers/payment-http';

@NgModule({
    declarations: [
        MyApp,
        AboutPage,
        ContactPage,
        HomePage,
        TabsPage,
        ProductsListPage,
        ProductDetailPage,
        MyCartPage,
        ButtonCartComponent,
        CheckoutPage
    ],
    imports: [
        BrowserModule,
        IonicModule.forRoot(MyApp, {}, {
            links: [
                {component: ProductsListPage, segment: 'products', name: 'Products'},
                {component: ProductDetailPage, segment: 'products/:product/detail', name: 'ProductDetail'},
                {component: MyCartPage, segment: 'my-cart', name: 'MyCart'},
                {component: CheckoutPage, segment: 'checkout', name: 'Checkout'},
            ]
        }),
        HttpModule
    ],
    bootstrap: [IonicApp],
    entryComponents: [
        MyApp,
        AboutPage,
        ContactPage,
        HomePage,
        TabsPage,
        ProductsListPage,
        ProductDetailPage,
        MyCartPage,
        CheckoutPage
    ],
    providers: [
        StatusBar,
        SplashScreen,
        {provide: ErrorHandler, useClass: IonicErrorHandler},
        ProductHttp,
        Cart,
        PaymentHttp
    ]
})
export class AppModule {
}
