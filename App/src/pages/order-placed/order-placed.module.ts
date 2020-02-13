import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { OrderPlacedPage } from './order-placed';

@NgModule({
  declarations: [
    OrderPlacedPage,
  ],
  imports: [
    IonicPageModule.forChild(OrderPlacedPage),
  ],
})
export class OrderPlacedPageModule {}
