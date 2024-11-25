import { Routes } from '@angular/router';
import { AuthenticationComponent } from './authentication/authentication.component';
import { CarsComponent } from './cars/cars.component';
import { RentsComponent } from './rents/rents.component';

export const routes: Routes = [
  { path: '', component: AuthenticationComponent },
  { path: 'cars', component: CarsComponent },

  { path: 'rents', component: RentsComponent},
];
