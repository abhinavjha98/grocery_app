import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { OrderConfirmPage } from './order-confirm';

@NgModule({
  declarations: [
    OrderConfirmPage,
  ],
  imports: [
    IonicPageModule.forChild(OrderConfirmPage),
  ],
})
export class OrderConfirmPageModule {}
