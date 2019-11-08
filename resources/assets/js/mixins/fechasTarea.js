export default {
  methods: {
    tiempoReloj(tarea) {
      let start = moment(tarea.attributes.tar_fecha_derivacion);
      let end = null;
      tarea.relationships.usuarios.forEach(usuario => {
        if (usuario.attributes.pivot.dias_plazo > 0) {
          let s = moment(
            usuario.attributes.pivot.fecha_registro ||
            tarea.attributes.tar_fecha_derivacion
          );
          let e = s.addWorkdays(usuario.attributes.pivot.dias_plazo);
          end = end ? moment.max(end, e) : e;
        }
      });
      return end
        ? Math.min(
          100,
          Math.round((-100 * moment().diff(start)) / start.diff(end))
        )
        : 0;
    },
    diasPasados(tarea) {
      const dias = moment().getBusinessDays(
        moment(tarea.attributes.tar_fecha_derivacion)
      );
      return (
        (dias >= 0 ? "en " : "hace ") +
        Math.abs(dias) +
        (dias == 1 ? " día hábil" : " días hábiles")
      );
    },
    maxDiasPlazo(tarea) {
      let end = null;
      let diasPlazo = 0;
      tarea.relationships.usuarios.forEach(usuario => {
        if (usuario.attributes.pivot.dias_plazo > 0) {
          let s = moment(
            usuario.attributes.pivot.fecha_registro ||
            tarea.attributes.tar_fecha_derivacion
          );
          let e = s.addWorkdays(usuario.attributes.pivot.dias_plazo);
          if (end === null || e === moment.max(end, e)) {
            diasPlazo = usuario.attributes.pivot.dias_plazo;
            end = e;
          }
        }
      });
      return diasPlazo;
    },
    tiempoRelojUsuario(tarea, usuario) {
      let start = moment(usuario.attributes.pivot.fecha_registro ||
        tarea.attributes.tar_fecha_derivacion);
      let end = null;
      if (usuario.attributes.pivot.dias_plazo > 0) {
        let s = moment(
          usuario.attributes.pivot.fecha_registro ||
          tarea.attributes.tar_fecha_derivacion
        );
        let e = s.addWorkdays(usuario.attributes.pivot.dias_plazo);
        end = end ? moment.max(end, e) : e;
      }
      return end
        ? Math.min(
          100,
          Math.round((-100 * moment().diff(start)) / start.diff(end))
        )
        : 0;
    },
    tiempoDisponibleUsuario(tarea, usuario) {
      const dias = moment().getBusinessDays(
        moment(
          usuario.attributes.pivot.fecha_registro ||
          tarea.attributes.tar_fecha_derivacion
        ).addWorkdays(usuario.attributes.pivot.dias_plazo)
      );
      return usuario.attributes.pivot.dias_plazo > 0 ? (dias == 0 ? " hoy" :(
        (dias > 0 ? "en " : "hace ") +
        Math.abs(dias) +
        (dias == 1 ? " día hábil" : " días hábiles")
      )) : "";
    },
  },
};
