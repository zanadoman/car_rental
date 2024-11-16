import { HttpClient } from '@angular/common/http';
import { Component, inject } from '@angular/core';
import { environment } from '../../environment/environment';
import { Router } from '@angular/router';
import { NgIf } from '@angular/common';

@Component({
  selector: 'app-nav',
  standalone: true,
  imports: [NgIf],
  templateUrl: './nav.component.html',
  styleUrl: './nav.component.css'
})
export class NavComponent {
  private router = inject(Router)
  private httpClient = inject(HttpClient)

  userName: string | null = null

  ngOnInit() {
    this.router.events.subscribe({
      next: () => this.userName = sessionStorage.getItem('userName')
    })
  }

  logout() {
    console.log('request started')
    this.httpClient.post(
      environment.apiUrl + '/logout',
      null,
      { withCredentials: true }
    ).subscribe({
      error: error => console.log(error.error),
      complete: () => {
        sessionStorage.clear()
        console.log('request completed')
        this.router.navigate([''])
      }
    })
  }
}
