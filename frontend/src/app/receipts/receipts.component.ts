import { HttpClient } from '@angular/common/http';
import { Component, inject } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { Receipts } from './receipts.model';
import { environment } from '../../environment/environment';
import { NgFor } from '@angular/common';

@Component({
  selector: 'app-receipts',
  standalone: true,
  imports: [NgFor],
  templateUrl: './receipts.component.html',
  styleUrl: './receipts.component.css'
})
export class ReceiptsComponent {
  private router = inject(Router)
  private httpClient = inject(HttpClient)
  private formBuilder = inject(FormBuilder)

  userRole = 'visitor'

  receipts: Receipts[] = []
  filteredCategories: string[] = []
  filteredReceipts: Receipts[] = []
  filteredForms = new Map<number, FormGroup>

  constructor() {
    this.userRole = sessionStorage.getItem('userRole') || 'visitor'
    if (!['customer', 'salesman', 'admin'].includes(this.userRole)) {
      this.router.navigate([''])
    }
  }

  ngOnInit() {
    this.getReceipts()
  }

  getReceipts() {
    console.log('request started')
    this.httpClient.get<Receipts[]>(
      `${environment.apiUrl}/receipts`,
      { withCredentials: true }
    ).subscribe({
      next: receipt => {
        console.log(receipt)
        this.receipts = receipt
      },
      error: error => console.log(error.error),
      complete: () => {
        console.log('request completed')
      }
    })
  }
}
