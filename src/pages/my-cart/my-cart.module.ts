import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { MyCartPage } from './my-cart';

@NgModule({
  declarations: [
    MyCartPage,
  ],
  imports: [
    IonicPageModule.forChild(MyCartPage),
  ],
})
export class MyCartPageModule {}
