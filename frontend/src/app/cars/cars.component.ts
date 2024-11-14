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
    if (['1', '2', '3', '4'].includes(sessionStorage.getItem('userRole') || '0')) {
      this.router.navigate([''])
    }
  }
}
