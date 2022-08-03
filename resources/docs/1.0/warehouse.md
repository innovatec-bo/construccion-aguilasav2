# Almacen

---

- [Descripci&oacute;n](#description)
- [Movimientos](#movements)
- [Movimientos agrupados](#grouped-movements)
- [Constructores y deudas](#builder-debts)
- [Salidas observadas](#duplicated-movements)

<a name="description"></a>
## [Descripci&oacute;n](#description)

En esta seccion se aprecian las herramientas que ayudan con la administracion del Almacen interno.

<a name="movements"></a>
## [Movimientos](#movements)

Todos los movimientos estan registrados en esta seccion, los movimientos pueden ser los siguientes:

1. Lista inicial
2. Lista adicional
3. Material retirado de cre
4. Material entregado al contructor
5. Material devuelto a CRE
6. Ingreso por conciliacion 221
7. Ajuste
8. Egreso por conciliación 222
9. Solicitud de materiales
10. Solicitud de prestamo de materiales
11. Solicitud de adicional a CRE
12. Material entregado al contructor (prestamo)
13. Constructor devuelve materiales

Solo uno de los movimientos(5,8) estara vigente cuando se complete el flujo de la conciliacion.

<a name="grouped-movements"></a>
## [Movimientos agrupados](#grouped-movements)

Esta seccion es similar a "Movimmientos", en esta seccion los movimientos se encuentran agrupados por proyecto. Una de las ventajas de esta vista es que se puede hacer un tracking de los materiales, osea se puede saber como se ha ido moviendo a lo largo del proyecto.

<a name="builder-debts"></a>
## [Constructores y deudas](#builder-debts)

Todos los constructores que deben materiales aparecen en esta seccion. La lista se puede filtrar por constructor y por el estado del proyecto.

<a name="duplicated-movements"></a>
## [Salidas observadas](#duplicated-movements)

Reporte creado con el fin de depurar los movimientos del almacen. Este reporte lista los materiales que aparentemente han sido incluidos en movimientos de forma accidental.