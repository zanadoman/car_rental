import { Component, inject } from '@angular/core';
import { Router } from '@angular/router';
@Component({
  selector: 'app-rents',
  standalone: true,
  imports: [],
  templateUrl: './rents.component.html',
  styleUrl: './rents.component.css'
})
export class RentsComponent {
  private router = inject(Router);

  userRole = 'visitor'

  constructor() {
    this.userRole = sessionStorage.getItem('userRole') || 'visitor'
      if (!['customer', 'mechanic', 'salesman', 'admin'].includes(this.userRole)) {
        this.router.navigate([''])
      }
  }
}
