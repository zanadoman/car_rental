import { Component, inject } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-cars',
  standalone: true,
  imports: [],
  templateUrl: './cars.component.html',
  styleUrl: './cars.component.css'
})
export class CarsComponent {
  private router = inject(Router)

  constructor() {
    if (!['customer', 'mechanic', 'salesman', 'admin']
      .includes(sessionStorage.getItem('userRole') || 'visitor')) {
      this.router.navigate([''])
    }
  }
}
