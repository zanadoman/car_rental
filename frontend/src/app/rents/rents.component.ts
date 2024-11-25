import { NgFor } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { Component, inject } from '@angular/core';
import { FormBuilder } from '@angular/forms';
import { Router } from '@angular/router';
import { environment } from '../../environment/environment';
import { Rent } from './rent.model';
@Component({
  selector: 'app-rents',
  standalone: true,
  imports: [NgFor],
  templateUrl: './rents.component.html',
  styleUrl: './rents.component.css'
})
export class RentsComponent {
  private router = inject(Router);
  private httpClient = inject(HttpClient)
  private formBuilder = inject(FormBuilder)

  userRole = 'visitor'
  currentDate = new Date

  rentForm = this.formBuilder.group({

  })

  rents: Rent[] = []



  constructor() {
    this.userRole = sessionStorage.getItem('userRole') || 'visitor'
      if (!['customer', 'mechanic', 'salesman', 'admin'].includes(this.userRole)) {
        this.router.navigate([''])
      }
  }

  ngOnInit() {
    this.getRents()
  }

  getRents() {
    console.log('request started')
    this.httpClient.get<Rent[]>(
      `${environment.apiUrl}/rents`,
      { withCredentials: true }
    ).subscribe({
      next: rents => {
        console.log(rents)
        this.rents = rents
      },
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')

      }
    })
  }
}
