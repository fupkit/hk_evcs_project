import { Injectable } from '@angular/core';
import { environment } from "../environments/environment"
import { HttpClient, HttpParams, HttpHeaders } from "@angular/common/http";
import { Station } from './station/station';
@Injectable({
  providedIn: 'root'
})
export class ApiService {
  basePath: string;
  constructor(private http: HttpClient) {
    this.basePath = environment.apiEndPoint;
  }

  getAll() {
    return this.http.get(this.basePath + 'station.php');
  }

  getById(id: number) {
    return this.http.get(this.basePath + 'station.php' + '/' + id);
  }

  search(loc: string) {
    let params = new HttpParams()
      .set('loc', loc);

    return this.http.get(this.basePath + 'station.php', {
      params: params
    });
  }

  insert(station: any) {
    let params = new HttpParams()
      .set('station', JSON.stringify(station));
    return this.http.post(this.basePath + 'station.php', params);
  }

  update(id: number, station: Station) {
    const httpOptions = {
      headers: new HttpHeaders({ 'Content-Type': 'application/json' })
    };
    let data = {
      station : station
    };
    return this.http.put(this.basePath + 'station.php' + '/' + id, data, httpOptions);
  }

  delete(id: number) {
    return this.http.delete(this.basePath + 'station.php' + '/' + id);
  }

  getDistrict(lang) {
    let params = new HttpParams()
      .set('lang', lang);
    return this.http.get(this.basePath + 'district.php', { params: params });
  }

  getArea(lang) {
    let params = new HttpParams()
    .set('lang', lang);
  return this.http.get(this.basePath + 'district.php/area', { params: params });
  }

}
